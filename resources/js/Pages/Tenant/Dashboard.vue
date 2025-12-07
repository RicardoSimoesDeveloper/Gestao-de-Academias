<script setup>
import { Head } from '@inertiajs/vue3';
// Assumindo que você tem um layout específico para o Tenant
import TenantLayout from '@/Layouts/TenantLayout.vue'; 

const props = defineProps({
    metrics: Object,
    academiaNome: String,
});

// Array de dados para os cartões
const cards = [
    { 
        title: 'Total de Membros', 
        value: props.metrics.totalAlunos, 
        icon: 'users', 
        color: 'bg-blue-600',
        description: 'Total geral de cadastros ativos e inativos.'
    },
    { 
        title: 'Membros Ativos', 
        value: props.metrics.ativos, 
        icon: 'user-check', 
        color: 'bg-green-600',
        description: 'Alunos com status "ativo".'
    },
    { 
        title: 'Novos no Mês', 
        value: props.metrics.novosMes, 
        icon: 'trending-up', 
        color: 'bg-yellow-600',
        description: 'Alunos cadastrados nos últimos 30 dias.'
    },
    { 
        title: 'Rotatividade', 
        value: `${props.metrics.taxaRotatividade}%`, 
        icon: 'rotate-cw', 
        color: 'bg-red-600',
        description: 'Percentual de alunos inativos.'
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <TenantLayout :title="`Dashboard da ${academiaNome}`">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Visão Geral da Unidade</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="(card, index) in cards" :key="index"
                 class="bg-white p-6 rounded-xl shadow-lg border-t-4 transition-transform duration-300 hover:shadow-xl"
                 :class="`border-${card.color.replace('bg-', '')}`">
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-500 uppercase">{{ card.title }}</span>
                    <div :class="[card.color, 'p-2 rounded-full text-white']">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="card.icon === 'users' ? 'M17 20v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 8a4 4 0 100-8 4 4 0 000 8z' : card.icon === 'user-check' ? 'M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 8a4 4 0 100-8 4 4 0 000 8zM21 12l-5 5L13 14' : card.icon === 'trending-up' ? 'M16 6l4-4 4 4M2 18h20' : 'M12 2v20M20 12H4'"></path></svg>
                    </div>
                </div>

                <p class="text-4xl font-extrabold text-gray-900 mt-4">{{ card.value }}</p>
                <p class="text-xs text-gray-500 mt-2">{{ card.description }}</p>
            </div>
        </div>
        
        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Atividade Recente</h2>
            <div class="bg-white p-6 rounded-xl shadow-lg min-h-[200px] text-gray-400 flex items-center justify-center">
                [Área para Gráficos de Check-in e Registros - Em Desenvolvimento]
            </div>
        </div>
        
    </TenantLayout>
</template>