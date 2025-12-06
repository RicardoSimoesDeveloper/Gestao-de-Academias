<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold">Painel da Academia: {{ academia }}</h1>
    <p>Plano atual: {{ plano }}</p>
    
    <div class="mt-4 bg-white shadow rounded-lg p-4">
        <p>Bem-vindo ao seu sistema de gestão.</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
    academia: String,
    plano: String
});
</script>