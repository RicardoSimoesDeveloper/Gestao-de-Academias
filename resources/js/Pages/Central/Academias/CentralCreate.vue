<template>
    <CentralLayout title="Nova Academia">
        <div class="bg-white p-6 rounded shadow max-w-3xl mx-auto">
            <h2 class="text-lg font-bold mb-4 border-b pb-2">Dados da Franquia</h2>
            <form @submit.prevent="form.post('/admin/nova-academia')">
               <div class="mb-4">
                    <label class="block font-bold mb-1">ID (Subdomínio)</label>
                    <input
                        v-model="form.id"
                        type="text"
                        class="w-full border p-2 rounded"
                        :class="{ 'border-red-500': form.errors.id }"
                        placeholder="Ex: ironberg"
                    >
                    <p class="text-red-600 text-sm mt-1" v-if="form.errors.id">
                        {{ form.errors.id }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">O acesso será: {{ form.id }}.aplicacao.local</p>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-1">Nome</label>
                    <input
                        v-model="form.name"
                        class="w-full border p-2 rounded"
                        :class="{ 'border-red-500': form.errors.name }"
                    >
                    <p class="text-red-600 text-sm mt-1" v-if="form.errors.name">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-bold mb-1">Email Admin</label>
                        <input
                            v-model="form.email_admin"
                            type="email"
                            class="w-full border p-2 rounded"
                            :class="{ 'border-red-500': form.errors.email_admin }"
                        >
                        <p class="text-red-600 text-sm mt-1" v-if="form.errors.email_admin">
                            {{ form.errors.email_admin }}
                        </p>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Senha</label>
                        <input
                            v-model="form.senha_admin"
                            type="text"
                            class="w-full border p-2 rounded"
                            :class="{ 'border-red-500': form.errors.senha_admin }"
                        >
                        <p class="text-red-600 text-sm mt-1" v-if="form.errors.senha_admin">
                            {{ form.errors.senha_admin }}
                        </p>
                    </div>
                </div>


                <div class="flex justify-end gap-3 mt-6">
                    <Link href="/admin/academias" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancelar</Link>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Criar Unidade</button>
                </div>
            </form>
        </div>
    </CentralLayout>
</template>

<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue'; // <--- Importe o layout
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    id: '',
    name: '',
    email_admin: '',
    senha_admin: ''
});
</script>