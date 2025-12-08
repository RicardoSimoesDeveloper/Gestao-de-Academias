<template>
    <div v-if="links.length > 3" class="mt-6 flex justify-center">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links" :key="key">
                <div v-if="link.url === null" 
                    class="mr-1 mb-1 px-4 py-2 text-sm leading-4 text-gray-400 border rounded cursor-default" 
                    v-html="link.label" 
                />
                
                <Link v-else
                    class="mr-1 mb-1 px-4 py-2 text-sm leading-4 border rounded hover:bg-gray-100 focus:border-blue-500 focus:text-blue-500 transition"
                    :class="{ 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
        default: () => []
    }
});
</script>