<script setup>
import { Head } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue';
import DashboardCard from '@/Components/Ui/Shared/DashboardCard.vue';

const props = defineProps({
    metrics: Object,
    academiaNome: String,
});

const cardsData = [
    { 
        title: 'Total de Membros', 
        value: props.metrics.totalAlunos, 
        color: 'blue',
        description: 'Total geral de cadastros ativos e inativos.'
    },
    { 
        title: 'Membros Ativos', 
        value: props.metrics.ativos, 
        color: 'green',
        description: 'Alunos com status "ativo".'
    },
    { 
        title: 'Novos no Mês', 
        value: props.metrics.novosMes, 
        color: 'yellow',
        description: 'Alunos cadastrados nos últimos 30 dias.'
    },
    { 
        title: 'Rotatividade', 
        value: `${props.metrics.taxaRotatividade}%`, 
        color: 'red',
        description: 'Percentual de alunos inativos.'
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <TenantLayout :title="`Dashboard da ${props.academiaNome ?? 'Unidade'}`">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Visão Geral da {{ props.academiaNome ?? 'Unidade' }}
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <DashboardCard v-for="(card, index) in cardsData" :key="index"
                           :title="card.title"
                           :value="card.value"
                           :color="card.color"
                           :description="card.description"
            />
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Atividade Recente</h2>
            <div class="bg-white p-6 rounded-xl shadow-lg min-h-[200px] text-gray-400 flex items-center justify-center">
                Área para Gráficos de Check-in e Registros - Em Desenvolvimento
            </div>
        </div>

    </TenantLayout>
</template>
