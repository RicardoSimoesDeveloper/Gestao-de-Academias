<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    id: '',
    name: '',
    email_admin: '',
    senha_admin: ''
});

const showPassword = ref(false);
const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
</script>

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
                        required
                    >
                    <!-- Múltiplos erros -->
                    <template v-if="form.errors.id">
                        <p v-for="(error, index) in Array.isArray(form.errors.id) ? form.errors.id : [form.errors.id]" 
                           :key="index"
                           class="text-red-600 text-sm mt-1">
                            {{ error }}
                        </p>
                    </template>
                    <p class="text-xs text-gray-500 mt-1">O acesso será: {{ form.id }}.aplicacao.local</p>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-1">Nome</label>
                    <input
                        v-model="form.name"
                        class="w-full border p-2 rounded"
                        :class="{ 'border-red-500': form.errors.name }"
                        required
                    >
                    <template v-if="form.errors.name">
                        <p v-for="(error, index) in Array.isArray(form.errors.name) ? form.errors.name : [form.errors.name]" 
                           :key="index"
                           class="text-red-600 text-sm mt-1">
                            {{ error }}
                        </p>
                    </template>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-bold mb-1">Email Admin</label>
                        <input
                            v-model="form.email_admin"
                            type="email"
                            class="w-full border p-2 rounded"
                            :class="{ 'border-red-500': form.errors.email_admin }"
                            required
                        >
                        <template v-if="form.errors.email_admin">
                            <p v-for="(error, index) in Array.isArray(form.errors.email_admin) ? form.errors.email_admin : [form.errors.email_admin]" 
                               :key="index"
                               class="text-red-600 text-sm mt-1">
                                {{ error }}
                            </p>
                        </template>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Senha</label>
                        <div class="relative">
                            <input
                                v-model="form.senha_admin"
                                :type="showPassword ? 'text' : 'password'"
                                class="w-full border p-2 rounded pr-10"
                                :class="{ 'border-red-500': form.errors.senha_admin }"
                                required
                            >
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-600"
                                @click="togglePassword"
                            >
                                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.732-3.953M6.18 6.18A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.594 2.925M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <template v-if="form.errors.senha_admin">
                            <p v-for="(error, index) in Array.isArray(form.errors.senha_admin) ? form.errors.senha_admin : [form.errors.senha_admin]" 
                               :key="index"
                               class="text-red-600 text-sm mt-1">
                                {{ error }}
                            </p>
                        </template>
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
