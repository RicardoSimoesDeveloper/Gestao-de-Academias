<template>
    <div class="min-h-screen bg-gray-50 p-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-6">Cadastrar Nova Academia</h1>
            
            <form @submit.prevent="form.post('/admin/nova-academia')">
                <div class="mb-4">
                    <label class="block font-bold mb-1">ID (Subdomínio)</label>
                    <input v-model="form.id" type="text" class="w-full border p-2 rounded" placeholder="Ex: ironberg">
                    <p class="text-xs text-gray-500 mt-1">O acesso será: {{ form.id }}.aplicacao.local</p>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-1">Nome da Academia</label>
                    <input v-model="form.nome" type="text" class="w-full border p-2 rounded">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-bold mb-1">Email do Admin</label>
                        <input v-model="form.email_admin" type="email" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block font-bold mb-1">Senha Inicial</label>
                        <input v-model="form.senha_admin" type="text" class="w-full border p-2 rounded">
                    </div>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Criar Academia e Banco de Dados
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    id: '',
    nome: '',
    email_admin: '',
    senha_admin: '123456'
});
</script>