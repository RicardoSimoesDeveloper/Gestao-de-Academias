<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue';
// import { useToast } from '@/Composables/toast'; // Para notificações

const props = defineProps({
    aluno: Object, // Objeto Aluno que vem do controller
    // errors: Object // Se não estiver usando form.errors
});

// Inicializa o formulário com os dados do aluno
const form = useForm({
    _method: 'put', // 🚨 MUITO IMPORTANTE: Define o método HTTP para PUT/PATCH
    nome: props.aluno.nome,
    email: props.aluno.email,
    cpf: props.aluno.cpf,
    data_nascimento: props.aluno.data_nascimento,
    status: props.aluno.status,
});

const submit = () => {
    // Rota de atualização: alunos.update
    form.post(route('alunos.update', props.aluno.id), {
        onSuccess: () => {
            // useToast().success('Aluno atualizado!');
        },
        onError: (errors) => {
            // console.error(errors);
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
            <form @submit.prevent="submit">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                        <input id="nome" v-model="form.nome" type="text" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            :class="{'border-red-500': form.errors.nome}"
                            required>
                        <div v-if="form.errors.nome" class="text-xs text-red-500 mt-1">{{ form.errors.nome }}</div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" v-model="form.email" type="email" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            :class="{'border-red-500': form.errors.email}"
                            required>
                        <div v-if="form.errors.email" class="text-xs text-red-500 mt-1">{{ form.errors.email }}</div>
                    </div>

                    <div>
                        <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                        <input id="cpf" v-model="form.cpf" type="text" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            :class="{'border-red-500': form.errors.cpf}">
                        <div v-if="form.errors.cpf" class="text-xs text-red-500 mt-1">{{ form.errors.cpf }}</div>
                    </div>

                    <div>
                        <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                        <input id="data_nascimento" v-model="form.data_nascimento" type="date" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            :class="{'border-red-500': form.errors.data_nascimento}">
                        <div v-if="form.errors.data_nascimento" class="text-xs text-red-500 mt-1">{{ form.errors.data_nascimento }}</div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" v-model="form.status" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            :class="{'border-red-500': form.errors.status}"
                            required>
                            <option v-for="option in statusOptions" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                        <div v-if="form.errors.status" class="text-xs text-red-500 mt-1">{{ form.errors.status }}</div>
                    </div>

                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end gap-3">
                    <Link :href="route('alunos.index')" class="px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 transition">
                        Cancelar
                    </Link>
                    <button type="submit" :disabled="form.processing"
                        class="px-4 py-2 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 transition disabled:opacity-50">
                        {{ form.processing ? 'Atualizando...' : 'Salvar Alterações' }}
                    </button>
                </div>
            </form>
        </div>
    </TenantLayout>
</template>