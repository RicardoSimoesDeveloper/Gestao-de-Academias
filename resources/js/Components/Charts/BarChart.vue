<script setup>
import { Bar } from 'vue-chartjs'
import {
    Chart,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
} from 'chart.js'

Chart.register(BarElement, CategoryScale, LinearScale, Tooltip, Legend)

defineProps({
    labels: Array,         // nomes das academias
    dataValues: Array,     // número de alunos
})
</script>

<template>
    <Bar
        :data="{
            labels: labels,
            datasets: [
                {
                    label: 'Alunos por Academia',
                    data: dataValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                }
            ]
        }"
        :options="{
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }"
    />
</template>
