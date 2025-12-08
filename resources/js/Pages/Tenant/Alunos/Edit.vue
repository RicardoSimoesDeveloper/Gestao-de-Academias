<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue';
// import { useToast } from '@/Composables/toast';

const props = defineProps({
    aluno: Object, // 🚨 ESSENCIAL: O objeto Aluno deve ser passado pelo Controller
});

// Inicializa o formulário com os dados do aluno existente
const form = useForm({
    // 🚨 CRÍTICO: Define o método HTTP para PUT/PATCH para a rota 'update'
    _method: 'put', 
    nome: props.aluno.nome,
    email: props.aluno.email,
    cpf: props.aluno.cpf,
    // Garante que o formato de data esteja correto para o input HTML (YYYY-MM-DD)
    data_nascimento: props.aluno.data_nascimento ? props.aluno.data_nascimento.substring(0, 10) : null,
    status: props.aluno.status,
});

const submit = () => {
    // 🚨 Rota de atualização: /alunos/{id} (o _method: 'put' faz o resto)
    form.post(`/alunos/${props.aluno.id}`, {
        onSuccess: () => {
            // useToast().success('Aluno atualizado com sucesso!');
        },
        onError: (errors) => {
            console.error('Erros de validação:', errors);
        },
    });
};

const statusOptions = ref([
    { value: 'ativo', label: 'Ativo' },
    { value: 'inativo', label: 'Inativo' },
    { value: 'suspenso', label: 'Suspenso' },
]);
</script>

<template>
    <Head :title="`Editar ${aluno.nome}`" />

    <TenantLayout :title="`Editar Aluno: ${aluno.nome}`">
        <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Editar dados do aluno(a) {{ aluno.nome }}</h2>
            
            <form @submit.prevent="submit">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo <span class="text-red-500">*</span></label>
                        <input id="nome" v-model="form.nome" type="text" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
                            required>
                        <div v-if="form.errors.nome" class="text-xs text-red-500 mt-1">{{ form.errors.nome }}</div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input id="email" v-model="form.email" type="email" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
                            required>
                        <div v-if="form.errors.email" class="text-xs text-red-500 mt-1">{{ form.errors.email }}</div>
                    </div>

                    <div>
                        <label for="cpf"class="block text-sm font-semibold text-gray-700 mb-2">CPF</label>
                        <input id="cpf" v-model="form.cpf" type="text" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                        <div v-if="form.errors.cpf" class="text-xs text-red-500 mt-1">{{ form.errors.cpf }}</div>
                    </div>

                    <div>
                        <label for="data_nascimento"class="block text-sm font-semibold text-gray-700 mb-2">Data de Nascimento</label>
                        <input id="data_nascimento" v-model="form.data_nascimento" type="date" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                        <div v-if="form.errors.data_nascimento" class="text-xs text-red-500 mt-1">{{ form.errors.data_nascimento }}</div>
                    </div>

                    <div>
                        <label for="status"class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select id="status" v-model="form.status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
                            required>
                            <option v-for="option in statusOptions" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                        <div v-if="form.errors.status" class="text-xs text-red-500 mt-1">{{ form.errors.status }}</div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end gap-3">
                    <Link href="/alunos" class="px-6 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition font-semibold">
                        Cancelar
                    </Link>
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition disabled:opacity-50">
                        {{ form.processing ? 'Atualizando...' : 'Salvar Alterações' }}
                    </button>
                </div>
            </form>
        </div>
    </TenantLayout>
</template>