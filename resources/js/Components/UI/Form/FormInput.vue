<script setup>
// Evita que atributos não definidos como props sejam aplicados ao div raiz.
defineOptions({
  inheritAttrs: false
})

defineProps({
    modelValue: [String, Number, null],
    id: String,
    type: {
        type: String,
        default: 'text'
    },
    label: String,
    placeholder: String,
    error: String,
    required: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div>
        <label v-if="label" :for="id" class="block text-sm font-semibold text-gray-700 mb-2">
            {{ label }} 
            <span v-if="required" class="text-red-500">*</span>
        </label>
        
        <input 
            :id="id"
            :type="type" 
            :value="modelValue" 
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            
            v-bind="$attrs"
            
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
            :class="{'border-red-500': error}"
        >
        
        <div v-if="error" class="text-xs text-red-500 mt-1 flex items-center">
             <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ error }}
        </div>
    </div>
</template>

