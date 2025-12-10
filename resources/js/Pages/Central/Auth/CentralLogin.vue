<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: ''
});

const submit = () => {
    form.post('/login');
};
</script>

<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-900">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Painel Master</h2>
            <p class="text-center text-gray-500 mb-6">Acesso Restrito à Matriz</p>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                    <input v-model="form.email" type="email" class="w-full px-3 py-2 border rounded" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Senha</label>
                    <input v-model="form.password" type="password" class="w-full px-3 py-2 border rounded" required>
                </div>

                <button type="submit" :disabled="form.processing" class="w-full bg-gray-800 text-white font-bold py-2 px-4 rounded hover:bg-black">
                    Entrar na Central
                </button>
            </form>
            
            <div v-if="form.errors.email" class="mt-4 text-center text-red-500 text-sm">
                {{ form.errors.email }}
            </div>
        </div>
    </div>
</template>
