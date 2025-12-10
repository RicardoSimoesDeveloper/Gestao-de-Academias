<script setup>
defineProps({
    show: {
        type: Boolean,
        required: true
    }
});

defineEmits(['close']);
</script>

<template>
    <Transition name="modal-fade">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm transition-opacity">
            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm text-center transform transition-all scale-100">
                
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    <slot name="title">Sucesso!</slot>
                </h3>
                <p class="text-gray-500 mb-6">
                    <slot>A operação foi concluída corretamente.</slot>
                </p>
                
                <button @click="$emit('close')" class="w-full bg-gray-900 text-white py-2.5 rounded-lg hover:bg-gray-800 font-medium transition-colors">
                    <slot name="button-text">Ok, entendi</slot>
                </button>
            </div>
        </div>
    </Transition>
</template>


<style scoped>
/* Transição básica para o modal (opcional, mas profissional) */
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: opacity 0.3s ease;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
}
</style>