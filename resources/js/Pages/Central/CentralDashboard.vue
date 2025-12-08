<template>
    <CentralLayout title="Dashboard Geral">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
            <DashboardCard 
                title="Total de Academias"
                :value="totalTenants"
                color="blue"
            />
            
            <DashboardCard 
                title="Novas este mês"
                :value="newTenantsThisMonth"
                color="green"
            />

            <DashboardCard 
                title="Planos Ativos"
                :value="activePlansPercent"
                color="purple"
            />

            <DashboardCard 
                title="Alunos Totais"
                :value="totalAlunos"
                color="yellow"
            />
            
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
// 🚨 Importe o novo componente
import DashboardCard from '@/Components/Ui/Shared/DashboardCard.vue'; 

defineProps({
    totalTenants: Number,
    newTenantsThisMonth: Number, 
    activePlansPercent: String, 
    totalAlunos: Number, 
});
</script>