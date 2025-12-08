<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue';
// 🚨 Importe o novo componente
import FormInput from '@/Components/Ui/Form/FormInput.vue'; 
import { ref } from 'vue';

const form = useForm({
    nome: '',
    email: '',
    cpf: '',
    data_nascimento: '',
    status: 'ativo', 
});

const submit = () => {
    form.post('/alunos', { 
        onSuccess: () => {
            form.reset(); 
        },
        onError: (errors) => {
            console.error('Erros de validação:', errors);
        },
    });
};

// Mantemos o selectOptions, mas em um próximo passo, poderíamos componentizar o Select
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
                    
                    <FormInput
                        id="nome"
                        label="Nome Completo"
                        placeholder="Nome e Sobrenome"
                        v-model="form.nome" 
                        :error="form.errors.nome"
                        type="text"
                        required
                    />

                    <FormInput
                        id="email"
                        label="Email"
                        placeholder="exemplo@email.com"
                        v-model="form.email" 
                        :error="form.errors.email"
                        type="email"
                        required
                    />

                    <FormInput
                        id="cpf"
                        label="CPF"
                        placeholder="000.000.000-00"
                        v-model="form.cpf" 
                        :error="form.errors.cpf"
                        type="text"
                    />

                    <FormInput
                        id="data_nascimento"
                        label="Data de Nascimento"
                        v-model="form.data_nascimento" 
                        :error="form.errors.data_nascimento"
                        type="date"
                    />

                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" v-model="form.status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
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