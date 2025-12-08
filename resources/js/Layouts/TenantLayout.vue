<template>
    <div class="min-h-screen bg-gray-100 flex">
        <aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full transition-all duration-300 z-10">
            <div class="h-20 flex flex-col items-center justify-center border-b border-gray-800 bg-gray-900 px-2 text-center">
                <span class="text-sm font-bold tracking-wider text-blue-500 uppercase leading-tight">
                    Academia
                </span>
                
                <span class="text-xs font-semibold text-gray-400 mt-1 truncate px-2">
                    {{ academiaNome }}
                </span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                <SidebarLink href="/dashboard" activePrefix="/dashboard">
                    <template #icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </template>
                    Dashboard
                </SidebarLink>

                <SidebarLink href="/alunos" activePrefix="/alunos">
                    <template #icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 8a4 4 0 100-8 4 4 0 000 8z"></path></svg>
                    </template>
                    Alunos
                </SidebarLink>
            
            </nav>

            <div class="p-4 border-t border-gray-800">
                <button @click="logout" class="flex items-center w-full px-4 py-2 text-red-400 hover:bg-red-900/20 hover:text-red-300 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sair
                </button>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8 transition-all duration-300">
            <header class="flex justify-between items-center mb-8 bg-white p-4 rounded-lg shadow-sm">
                <h2 class="text-xl font-bold text-gray-800">{{ title }}</h2>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                        {{ user.initial }}
                    </div>
                    <span class="ml-2 text-sm text-gray-600">{{ user.name }}</span>
                </div>
            </header>

            <slot />
        </main>
    </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
// 🚨 Importe o novo componente
import SidebarLink from '@/Components/Layout/SidebarLink.vue'; 

const page = usePage();

// Puxa o nome da academia e o usuário de forma segura
const academiaNome = page.props.academiaNome || 'Unidade'; 

// 🚨 Lógica segura para obter o usuário logado e a inicial
const user = computed(() => {
    const authUser = page.props.auth ? page.props.auth.user : null;
    return {
        name: authUser ? authUser.name : 'Admin',
        initial: authUser ? authUser.name.charAt(0).toUpperCase() : 'A',
    };
});

defineProps({
    title: String
});

const logout = () => {
    router.post('/logout'); 
};
</script>