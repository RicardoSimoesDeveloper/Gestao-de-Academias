<template>
    <CentralLayout title="Dashboard Geral">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <p class="text-sm text-gray-500 font-medium">Total de Academias</p>
                <p class="text-3xl font-bold text-gray-800">{{ totalTenants }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <p class="text-sm text-gray-500 font-medium">Novas este mês</p>
                <p class="text-3xl font-bold text-gray-800">2</p> </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                <p class="text-sm text-gray-500 font-medium">Planos Ativos</p>
                <p class="text-3xl font-bold text-gray-800">100%</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500 font-medium">Alunos Totais</p>
                <p class="text-3xl font-bold text-gray-800">--</p>
                <p class="text-xs text-gray-400">Em desenvolvimento</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold text-gray-700 mb-4">Crescimento de Unidades (2025)</h3>
            <div class="h-64 bg-gray-50 flex items-center justify-center border-2 border-dashed border-gray-200 rounded">
                <span class="text-gray-400">Gráfico de desempenho será exibido aqui</span>
            </div>
        </div>
    </CentralLayout>
</template>

<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue';

defineProps({
    totalTenants: Number
});
</script>