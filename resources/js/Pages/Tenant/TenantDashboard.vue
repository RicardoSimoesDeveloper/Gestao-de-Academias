<script setup>
import { Head } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue';
import DashboardCard from '@/Components/Ui/Shared/DashboardCard.vue';
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale
);

const props = defineProps({
  metrics: Object,
  academiaNome: String,
  graficoAlunos: Array,
});

// Dados dos cards
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

// Configuração do gráfico de linhas
const chartData = {
  labels: props.graficoAlunos.map(item => item.mes),
  datasets: [
    {
      label: 'Novos Alunos',
      data: props.graficoAlunos.map(item => item.total),
      fill: true,
      borderColor: '#3b82f6',
      backgroundColor: 'rgba(59, 130, 246, 0.2)',
      tension: 0.3,
      pointBackgroundColor: '#3b82f6',
      pointBorderColor: '#ffffff',
      pointRadius: 5,
    },
  ],
};

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { position: 'top' },
    tooltip: { enabled: true },
    title: {
      display: true,
      text: 'Novos Alunos Últimos 6 Meses',
      font: { size: 16 },
    },
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: { stepSize: 1 },
    },
    x: { grid: { display: false } },
  },
};
</script>

<template>
  <Head title="Dashboard" />

  <TenantLayout :title="`Dashboard da ${props.academiaNome ?? 'Unidade'}`">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
      Visão Geral da {{ props.academiaNome ?? 'Unidade' }}
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <DashboardCard 
        v-for="(card, index) in cardsData" 
        :key="index"
        :title="card.title"
        :value="card.value"
        :color="card.color"
        :description="card.description"
      />
    </div>

    <div class="mt-8">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Atividade Recente</h2>
      <div class="bg-white p-6 rounded-xl shadow-lg">
       <div class="w-full h-72">
          <Line :data="chartData" :options="chartOptions" />
        </div>
      </div>
    </div>

  </TenantLayout>
</template>
