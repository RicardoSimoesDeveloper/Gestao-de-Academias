<script setup>
import { Head } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue'; 

const props = defineProps({
    metrics: Object,
    academiaNome: String, // Passado do Controller
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
                
                <p class="text-4xl font-extrabold text-gray-900 mt-4">{{ card.value }}</p>
                <p class="text-xs text-gray-500 mt-2">{{ card.description }}</p>
            </div>
        </div>
        
        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Atividade Recente</h2>
            <div class="bg-white p-6 rounded-xl shadow-lg min-h-[200px] text-gray-400 flex items-center justify-center">
                Área para Gráficos de Check-in e Registros - Em Desenvolvimento
            </div>
        </div>
        
    </TenantLayout>
</template>