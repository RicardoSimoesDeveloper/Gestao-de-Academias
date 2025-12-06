<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-bold text-gray-800">Painel Master (Central)</span>
                    </div>
                    <div class="flex items-center">
                        <button @click="logout" class="text-red-600 hover:text-red-800 font-bold text-sm">
                            Sair do Sistema
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Academias Cadastradas</h1>
                <a href="/admin/nova-academia" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Nova Academia
                </a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subdomínio (ID)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domínio de Acesso</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="tenant in tenants" :key="tenant.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ tenant.name }}</div>
                                <div class="text-sm text-gray-500">{{ tenant.plan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ tenant.id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                <a :href="'http://' + tenant.domains[0].domain + ':8000'" target="_blank" class="hover:underline">
                                    {{ tenant.domains[0].domain }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-indigo-600 hover:text-indigo-900">Gerenciar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'; // Importe o router
defineProps({ tenants: Array });

const logout = () => {
    router.post('/logout');
};
</script>