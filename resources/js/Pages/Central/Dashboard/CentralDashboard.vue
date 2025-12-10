<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue'
import { defineProps } from 'vue'
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, BarElement, CategoryScale, LinearScale)

const props = defineProps({
  resumo: Object,
  detalhes: Array,
})

const chartData = {
  labels: props.detalhes.map((d) => d.nome),
  datasets: [
    {
      label: 'Alunos',
      backgroundColor: '#3b82f6',
      borderRadius: 6,
      data: props.detalhes.map((d) => d.alunos),
    },
  ],
}

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
}

const formatCurrency = (value) => {
  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  }).format(value)
}

const rowClass = (statusErro) => {
  return statusErro ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50'
}
</script>

<template>
  <CentralLayout title="Relatórios e Dashboard Geral">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard de Performance</h1>

    <!-- CARDS RESUMO -->
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
        <p class="text-3xl font-bold text-gray-800">
          {{ formatCurrency(resumo.total_faturamento) }}
        </p>
      </div>

      <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
        <p class="text-sm text-gray-500 font-medium">Ticket Médio (Estimado)</p>
        <p class="text-3xl font-bold text-gray-800">
          {{ formatCurrency(resumo.ticket_medio) }}
        </p>
      </div>
    </div>

    <!-- GRÁFICO -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h3 class="font-bold text-gray-700 mb-4">📊 Total de Alunos por Academia</h3>

        <div class="w-full h-72">
            <Bar :data="chartData" :options="chartOptions" />
        </div>
    </div>

  
  </CentralLayout>
</template>
