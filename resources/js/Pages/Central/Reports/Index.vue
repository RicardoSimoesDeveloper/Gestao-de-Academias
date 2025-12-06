<template>
    <CentralLayout title="Relatórios Consolidados">
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Faturamento Mensal (Est.)</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            {{ formatarMoeda(resumo.total_faturamento) }}
                        </p>
                    </div>
                    <div class="p-2 bg-green-50 rounded-lg text-green-600">
                        <span class="text-xl">💰</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total de Alunos</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ resumo.total_alunos }}</p>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                        <span class="text-xl">👥</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Unidades Ativas</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ resumo.total_tenants }}</p>
                    </div>
                    <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                        <span class="text-xl">🏢</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ticket Médio</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            {{ formatarMoeda(resumo.ticket_medio) }}
                        </p>
                    </div>
                    <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                        <span class="text-xl">🏷️</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Desempenho por Unidade</h3>
                <button class="text-sm text-blue-600 hover:underline">Exportar CSV</button>
            </div>
            
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs text-gray-500 uppercase bg-white border-b">
                        <th class="px-6 py-3 font-semibold">Unidade</th>
                        <th class="px-6 py-3 font-semibold text-center">Alunos Ativos</th>
                        <th class="px-6 py-3 font-semibold text-right">Faturamento (Est.)</th>
                        <th class="px-6 py-3 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr v-for="item in detalhes" :key="item.id" class="hover:bg-gray-50 border-b last:border-0 group">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800">{{ item.nome }}</div>
                            <div class="text-xs text-gray-400">{{ item.dominio }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-xs">
                                {{ item.alunos }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-mono text-gray-700">
                            {{ formatarMoeda(item.faturamento) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                                <span class="text-gray-600">Regular</span>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="detalhes.length === 0">
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Nenhuma unidade encontrada para gerar relatório.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </CentralLayout>
</template>

<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue';

// Recebe os dados do Controller
defineProps({
    resumo: Object,
    detalhes: Array
});

// Função auxiliar para formatar dinheiro (BRL)
const formatarMoeda = (valor) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(valor);
};
</script>