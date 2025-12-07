<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue';
// import { useToast } from '@/Composables/toast'; // Para notificações

const form = useForm({
    nome: '',
    email: '',
    cpf: '',
    data_nascimento: '',
    status: 'ativo', // Valor padrão
});

const submit = () => {
    // Usando o caminho absoluto para seguir o padrão seguro
    form.post('/alunos', { 
        onSuccess: () => {
            // useToast().success('Aluno cadastrado com sucesso!');
            form.reset(); 
        },
        onError: (errors) => {
            // Se necessário, use useToast().error('Verifique os campos.');
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
    <Head title="Novo Aluno" />

    <TenantLayout title="Cadastrar Novo Aluno">
        <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Dados Pessoais do Membro</h2>
            
            <form @submit.prevent="submit">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="nome" class="block text-sm font-bold text-gray-700">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input id="nome" v-model="form.nome" type="text" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                            :class="{'border-red-500': form.errors.nome}"
                            placeholder="Nome e Sobrenome"
                            required>
                        <div v-if="form.errors.nome" class="text-xs text-red-500 mt-1">{{ form.errors.nome }}</div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input id="email" v-model="form.email" type="email" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                            :class="{'border-red-500': form.errors.email}"
                            placeholder="exemplo@email.com"
                            required>
                        <p class="text-xs text-gray-500 mt-1">Deve ser único na academia.</p>
                        <div v-if="form.errors.email" class="text-xs text-red-500 mt-1">{{ form.errors.email }}</div>
                    </div>

                    <div>
                        <label for="cpf" class="block text-sm font-bold text-gray-700">CPF</label>
                        <input id="cpf" v-model="form.cpf" type="text" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                            :class="{'border-red-500': form.errors.cpf}"
                            placeholder="000.000.000-00">
                        <p class="text-xs text-gray-500 mt-1">Opcional, mas se preenchido, deve ser único.</p>
                        <div v-if="form.errors.cpf" class="text-xs text-red-500 mt-1">{{ form.errors.cpf }}</div>
                    </div>

                    <div>
                        <label for="data_nascimento" class="block text-sm font-bold text-gray-700">Data de Nascimento</label>
                        <input id="data_nascimento" v-model="form.data_nascimento" type="date" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                            :class="{'border-red-500': form.errors.data_nascimento}">
                        <div v-if="form.errors.data_nascimento" class="text-xs text-red-500 mt-1">{{ form.errors.data_nascimento }}</div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" v-model="form.status" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
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
                    <Link href="/alunos" class="px-6 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition font-semibold">
                        Cancelar
                    </Link>
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition disabled:opacity-50">
                        {{ form.processing ? 'Salvando...' : 'Cadastrar Aluno' }}
                    </button>
                </div>
            </form>
        </div>
    </TenantLayout>
</template>