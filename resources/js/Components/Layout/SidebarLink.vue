<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    href: {
        type: String,
        required: true
    },
    // Opcional: para links que só precisam de um prefixo, como /admin/academias
    activePrefix: String 
});

const page = usePage();

const isActive = computed(() => {
    if (props.activePrefix) {
        return page.url.startsWith(props.activePrefix);
    }
    return page.url === props.href;
});
</script>

<template>
    <Link :href="href" 
        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors"
        :class="{ 'bg-blue-600 text-white': isActive }">
        
        <div class="w-5 h-5 mr-3">
            <slot name="icon" />
        </div>
        
        <slot />
    </Link>
</template>