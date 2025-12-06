<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-bold text-blue-600">
                            {{ academia }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-700 mr-4">Olá, {{ user.nome }}</span>
                        
                        <button 
                            @click="logout" 
                            class="text-sm text-red-600 hover:text-red-800 font-medium"
                        >
                            Sair
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4">Visão Geral</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <p class="text-blue-600 font-bold">Alunos Ativos</p>
                                <p class="text-2xl font-bold">0</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                <p class="text-green-600 font-bold">Matrículas Hoje</p>
                                <p class="text-2xl font-bold">0</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                                <p class="text-purple-600 font-bold">Financeiro Mês</p>
                                <p class="text-2xl font-bold">R$ 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

// Recebe os dados enviados pelo Controller (Tenant/tenant.php)
defineProps({
    user: Object,
    academia: String
});

const logout = () => {
    router.post('/logout');
};
</script>