<template>
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full uppercase"
          :class="[statusClass]">
        {{ formattedStatus }}
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    status: {
        type: String,
        required: true,
        validator: (value) => ['ativo', 'inativo', 'suspenso'].includes(value.toLowerCase())
    }
});

// Mapeia o status para as classes Tailwind CSS
const statusClass = computed(() => {
    switch (props.status.toLowerCase()) {
        case 'ativo': return 'bg-green-100 text-green-800';
        case 'inativo': return 'bg-red-100 text-red-800';
        case 'suspenso': return 'bg-yellow-100 text-yellow-800';
        default: return 'bg-gray-100 text-gray-800';
    }
});

// Formata a string (primeira letra maiúscula)
const formattedStatus = computed(() => {
    if (!props.status) return '';
    return props.status.charAt(0).toUpperCase() + props.status.slice(1);
});
</script>