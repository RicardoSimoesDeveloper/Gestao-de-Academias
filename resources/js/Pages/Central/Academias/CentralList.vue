<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    tenants: Object,
    filters: Object 
});

const search = ref(props.filters?.search || '');

watch(search, debounce((value) => {
    router.get('/admin/academias', { search: value }, {
        preserveState: true,
        replace: true,
        only: ['tenants']
    });
}, 300)); 

const confirmarExclusao = (tenant) => {
    Swal.fire({
        title: 'Tem certeza?',
        text: `Você está prestes a excluir a academia "${tenant.name}" e apagar TODO o banco de dados dela.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir tudo!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/admin/academias/${tenant.id}`, {
                onSuccess: () => {
                    Swal.fire('Excluído!', 'A academia e os dados foram removidos.', 'success');
                },
                onError: () => {
                    Swal.fire('Erro!', 'Ocorreu um problema ao tentar excluir.', 'error');
                }
            });
        }
    });
};
</script>

<template>
    <CentralLayout title="Gestão de Unidades">
        <div class="flex justify-between items-center mb-6">
            <div class="relative">
                <input 
                    v-model="search" 
                    type="text" 
                    placeholder="Buscar por Nome ou ID..." 
                    class="pl-10 pr-4 py-2 border rounded-lg w-64"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <Link href="/admin/nova-academia" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nova Academia
            </Link>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 border-b font-semibold text-gray-600">ID</th>
                        <th class="p-4 border-b font-semibold text-gray-600">Nome da Unidade</th>
                        <th class="p-4 border-b font-semibold text-gray-600">Domínio</th>
                        <th class="p-4 border-b font-semibold text-gray-600">Plano</th>
                        <th class="p-4 border-b font-semibold text-gray-600 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="tenant in tenants.data" :key="tenant.id" class="hover:bg-gray-50 border-b last:border-0">
                        <td class="p-4 text-gray-500 text-sm">#{{ tenant.id }}</td>
                        <td class="p-4 font-medium text-gray-800">{{ tenant.name }}</td> 
                        <td class="p-4">
                            <a v-if="tenant.domains && tenant.domains.length > 0" 
                               :href="'http://' + tenant.domains[0].domain + ':8000'" 
                               target="_blank" 
                               class="text-blue-600 hover:underline flex items-center">
                                {{ tenant.domains[0].domain }}
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                            <span v-else class="text-gray-400 text-xs">Sem domínio</span>
                        </td>
                        <td class="p-4">
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Free</span>
                        </td>
                        <td class="p-4 text-right flex justify-end gap-2">
                            <Link 
                                :href="`/admin/academias/${tenant.id}/editar`" 
                                class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center"
                            >
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Editar
                            </Link>

                            <button 
                                @click="confirmarExclusao(tenant)" 
                                class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center ml-2"
                            >
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Excluir
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div v-if="tenants.data.length === 0" class="p-8 text-center text-gray-500">
                Nenhuma academia encontrada.
            </div>
        </div>
        
        <div v-if="tenants.links.length > 3" class="mt-4 flex justify-center">
            <div class="flex flex-wrap -mb-1">
                <template v-for="(link, key) in tenants.links" :key="key">
                    <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
                    <Link v-else
                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                        :class="{ 'bg-blue-600 text-white border-blue-600': link.active }"
                        :href="link.url"
                        v-html="link.label"
                    />
                </template>
            </div>
        </div>
        
    </CentralLayout>
</template>