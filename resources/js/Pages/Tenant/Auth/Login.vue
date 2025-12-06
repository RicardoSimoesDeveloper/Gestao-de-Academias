<template>
   <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                {{ academia }}
            </h2>
            
            <form @submit.prevent="enviarFormulario">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                    <input 
                        v-model="formulario.email" 
                        type="email" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{'border-red-500': formulario.errors.email}"
                    >
                    <p v-if="formulario.errors.email" class="text-red-500 text-xs mt-1">
                        {{ formulario.errors.email }}
                    </p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Senha</label>
                    <input 
                        v-model="formulario.senha" 
                        type="password" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <button 
                    type="submit" 
                    :disabled="formulario.processing"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Acessar Sistema
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

defineProps({
    academia: String
});

// Variável 'form' virou 'formulario'
// Campo 'password' virou 'senha'
const formulario = useForm({
    email: '',
    password: '',
});

const enviarFormulario = () => {
    formulario.post('/login');
};
</script>