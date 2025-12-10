<script setup>

import { router } from '@inertiajs/vue3';
import SidebarLink from '@/Components/Layout/SidebarLink.vue'; 

defineProps({
    title: String
});

const logout = () => {
    router.post('/logout');
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">
        <aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full transition-all duration-300 z-10">
            <div class="h-20 flex flex-col items-center justify-center border-b border-gray-800 bg-gray-900 px-2 text-center">
                <span class="text-sm font-bold tracking-wider text-blue-500 uppercase leading-tight">
                    Gerenciador de Academias
                </span>
                
                <span class="text-xs font-semibold text-gray-400 mt-1">
                    Central
                </span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                <SidebarLink href="/admin/dashboard" activePrefix="/admin/dashboard">
                    <template #icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </template>
                    Dashboard
                </SidebarLink>

                <SidebarLink href="/admin/academias" activePrefix="/admin/academias">
                    <template #icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </template>
                    Academias
                </SidebarLink>

                <SidebarLink href="/admin/relatorios" activePrefix="/admin/relatorios">
                    <template #icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </template>
                    Relatórios
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
                        A
                    </div>
                    <span class="ml-2 text-sm text-gray-600">Administrador</span>
                </div>
            </header>

            <slot />
        </main>
    </div>
</template>

