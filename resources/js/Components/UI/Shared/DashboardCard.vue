<template>
    <div class="bg-white p-6 rounded-lg shadow transition-transform duration-300 hover:shadow-xl relative overflow-hidden"
         :class="[borderClass]">
        
        <div class="absolute inset-y-0 left-0 w-1" :class="[colorClass]"></div>
        
        <p class="text-sm text-gray-500 font-medium mb-1">{{ title }}</p>
        <p class="text-3xl font-bold text-gray-800">{{ value }}</p>
        
        <p v-if="description" class="text-xs text-gray-400 mt-2">{{ description }}</p>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: [String, Number], // Pode ser um número ou uma string formatada (ex: "10%")
    color: {
        type: String,
        default: 'blue' // blue, green, purple, yellow, red, etc.
    },
    description: {
        type: String,
        default: ''
    }
});

// 🚨 Lógica para aplicar classes de cor dinamicamente
const colorMap = {
    blue: { border: 'border-l-4 border-blue-500', bg: 'bg-blue-500' },
    green: { border: 'border-l-4 border-green-500', bg: 'bg-green-500' },
    purple: { border: 'border-l-4 border-purple-500', bg: 'bg-purple-500' },
    yellow: { border: 'border-l-4 border-yellow-500', bg: 'bg-yellow-500' },
    red: { border: 'border-l-4 border-red-500', bg: 'bg-red-500' },
};

const borderClass = computed(() => colorMap[props.color]?.border || colorMap.blue.border);
const colorClass = computed(() => colorMap[props.color]?.bg || colorMap.blue.bg);

// Nota: A borda original é aplicada com `border-l-4`, mas vamos usar a div absoluta
// para ser mais flexível, mantendo o visual. Ajustamos o template para usar a div lateral
// e removemos a classe de borda do contêiner principal para evitar conflito.
</script>