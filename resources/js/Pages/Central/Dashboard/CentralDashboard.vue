<script setup>
defineProps({
    totalTenants: Number,
    newTenantsThisMonth: Number,
    totalAlunos: Number,
    activePlansPercent: String,
});
</script>

<template>
    <div class="p-6">

        <h1 class="text-3xl font-bold mb-6">Dashboard Central</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-gray-500 text-sm">Total de Academias</h2>
                <p class="text-3xl font-bold">{{ totalTenants }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-gray-500 text-sm">Novas no Mês</h2>
                <p class="text-3xl font-bold">{{ newTenantsThisMonth }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-gray-500 text-sm">Total de Alunos</h2>
                <p class="text-3xl font-bold">{{ totalAlunos }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-gray-500 text-sm">Planos Ativos</h2>
                <p class="text-3xl font-bold">{{ activePlansPercent }}</p>
            </div>

        </div>

    </div>
</template>
