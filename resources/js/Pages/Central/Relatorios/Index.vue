<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue';
import { defineProps } from 'vue';

const props = defineProps({
    resumo: Object, // Contém total_tenants, total_alunos, etc.
    detalhes: Array, // Tabela com dados por unidade
});

// Helper para formatar moeda
const formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(value);
};

// Helper para determinar a classe de erro (banco ausente)
const rowClass = (status_erro) => {
    return status_erro ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50';
};
</script>

<template>
    <CentralLayout title="Relatórios e Dashboard Geral">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard de Performance</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <p class="text-sm text-gray-500 font-medium">Total de Academias</p>
                <p class="text-3xl font-bold text-gray-800">{{ resumo.total_tenants }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500 font-medium">Total de Alunos</p>
                <p class="text-3xl font-bold text-gray-800">{{ resumo.total_alunos }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <p class="text-sm text-gray-500 font-medium">Faturamento Estimado</p>
                <p class="text-3xl font-bold text-gray-800">{{ formatCurrency(resumo.total_faturamento) }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                <p class="text-sm text-gray-500 font-medium">Ticket Médio (Estimado)</p>
                <p class="text-3xl font-bold text-gray-800">{{ formatCurrency(resumo.ticket_medio) }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold text-gray-700 mb-4">Detalhes por Unidade</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome da Unidade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domínio de Acesso</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Alunos</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Faturamento Estimado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="unidade in detalhes" :key="unidade.id" :class="rowClass(unidade.status_erro)">
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" 
                                :class="{'text-red-700 font-bold': unidade.status_erro, 'text-gray-900': !unidade.status_erro}">
                                {{ unidade.nome }}
                                <span v-if="unidade.status_erro" class="ml-2 text-xs bg-red-200 text-red-800 px-2 py-0.5 rounded">ERRO DB</span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a :href="`http://${unidade.dominio}:8000/login`" target="_blank" class="text-blue-500 hover:text-blue-700">
                                    {{ unidade.dominio }}
                                </a>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold" 
                                :class="{'text-red-700': unidade.status_erro, 'text-gray-800': !unidade.status_erro}">
                                {{ unidade.alunos }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold" 
                                :class="{'text-red-700': unidade.status_erro, 'text-green-600': !unidade.status_erro}">
                                {{ formatCurrency(unidade.faturamento) }}
                            </td>
                        </tr>
                        <tr v-if="detalhes.length === 0">
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Nenhuma academia cadastrada.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </CentralLayout>
</template>