<template>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Gestão de Alunos</h1>
                <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                    Total: {{ alunos.length }}
                </span>
            </div>

            <div class="bg-white p-4 rounded shadow mb-6">
                <h2 class="font-bold mb-4">Novo Aluno</h2>
                <form @submit.prevent="submit" class="flex gap-4">
                    <input v-model="form.nome" placeholder="Nome Completo" class="flex-1 border p-2 rounded" required>
                    <input v-model="form.email" placeholder="E-mail" class="flex-1 border p-2 rounded">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Salvar
                    </button>
                </form>
            </div>

            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 text-left">Nome</th>
                            <th class="p-4 text-left">Email</th>
                            <th class="p-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="aluno in alunos" :key="aluno.id" class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ aluno.nome }}</td>
                            <td class="p-4 text-gray-600">{{ aluno.email || '-' }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-xs rounded" 
                                    :class="aluno.status === 'ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                    {{ aluno.status }}
                                </span>
                            </td>
                        </tr>
                        <tr v-if="alunos.length === 0">
                            <td colspan="3" class="p-4 text-center text-gray-500">Nenhum aluno cadastrado.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

defineProps({ alunos: Array });

const form = useForm({
    nome: '',
    email: ''
});

const submit = () => {
    form.post('/alunos', {
        onSuccess: () => form.reset()
    });
};
</script>