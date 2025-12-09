<template>
    <Head title="Acesso da Academia" />
    
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                {{ academia }}
            </h2>
            
            <div 
                v-if="$page.props.errors && $page.props.errors.email" 
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" 
                role="alert"
            >
                <p class="text-sm">{{ $page.props.errors.email }}</p>
            </div>
            
            <form @submit.prevent="enviarFormulario">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                    <input 
                        v-model="formulario.email" 
                        type="email" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{'border-red-500': formulario.errors.email}"
                        required
                    >
                    <p v-if="formulario.errors.email" class="text-red-500 text-xs mt-1">
                        {{ formulario.errors.email }}
                    </p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Senha</label>
                    <input 
                        v-model="formulario.password" 
                        type="password" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{'border-red-500': formulario.errors.password}"
                        required
                    >
                    <p v-if="formulario.errors.password" class="text-red-500 text-xs mt-1">
                        {{ formulario.errors.password }}
                    </p>
                </div>

                <button 
                    type="submit" 
                    :disabled="formulario.processing"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50"
                >
                    {{ formulario.processing ? 'Acessando...' : 'Acessar Sistema' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm, Head } from '@inertiajs/vue3'; 

defineProps({
    academia: String
});

const formulario = useForm({
    email: '',
    password: '', 
});

const enviarFormulario = () => {
    formulario.post('/login', {
        onFinish: () => formulario.reset('password'),
        onError: (errors) => {
            console.error('Falha na submissão:', errors);
        },
    });
};
</script>