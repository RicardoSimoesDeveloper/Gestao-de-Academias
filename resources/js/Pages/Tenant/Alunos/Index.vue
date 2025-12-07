<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue'; 
import debounce from 'lodash/debounce';

const props = defineProps({
    alunos: Object, 
    filters: Object,
});

const search = ref(props.filters.search || '');

// Lógica de busca reativa (usando o caminho absoluto)
watch(search, debounce((value) => {
    router.get('/alunos', { search: value }, {
        preserveState: true,
        replace: true,
        only: ['alunos']
    });
}, 300));

// Função que define a cor do status
const statusClass = (status) => {
    switch (status) {
        case 'ativo': return 'bg-green-100 text-green-800';
        case 'inativo': return 'bg-red-100 text-red-800';
        case 'suspenso': return 'bg-yellow-100 text-yellow-800';
        default: return 'bg-gray-100 text-gray-800';
    }
};

// Lógica de Soft Delete (Usando caminho absoluto)
const destroy = (id) => {
    if (confirm('Tem certeza que deseja excluir (movê-lo para a lixeira) este aluno?')) {
        router.delete(`/alunos/${id}`); 
    }
};
</script>

<template>
    <Head title="Alunos" />

    <TenantLayout title="Gestão de Alunos">
        <div class="bg-white shadow rounded-lg p-6">
            
            <div class="flex justify-between items-center mb-6">
                <div class="relative w-full max-w-sm">
                    <input 
                        v-model="search"
                        type="text" 
                        placeholder="Buscar por nome ou CPF..." 
                        class="pl-10 pr-4 py-2 border rounded-lg w-full"
                    />
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                
                <Link href="/alunos/create" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center transition">
                    + Novo Aluno
                </Link>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 border-b font-semibold text-gray-600">ID</th>
                            <th class="p-4 border-b font-semibold text-gray-600">Nome</th>
                            <th class="p-4 border-b font-semibold text-gray-600">Email</th> <th class="p-4 border-b font-semibold text-gray-600">CPF</th>
                            <th class="p-4 border-b font-semibold text-gray-600">Status</th>
                            <th class="p-4 border-b font-semibold text-gray-600 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="aluno in alunos.data" :key="aluno.id" class="hover:bg-gray-50 border-b last:border-0">
                            <td class="p-4 text-gray-500 text-sm">#{{ aluno.id }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ aluno.nome }}</td>
                            <td class="p-4 text-gray-600">{{ aluno.email }}</td> <td class="p-4 text-gray-600">{{ aluno.cpf }}</td>
                            <td class="p-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                    :class="statusClass(aluno.status)">
                                    {{ aluno.status.charAt(0).toUpperCase() + aluno.status.slice(1) }}
                                </span>
                            </td>
                            <td class="p-4 text-right flex justify-end gap-3">
                                <Link :href="`/alunos/${aluno.id}/edit`" 
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    Editar
                                </Link>
                                
                                <button @click="destroy(aluno.id)" 
                                    class="text-red-500 hover:text-red-700 font-medium text-sm">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                        <tr v-if="alunos.data.length === 0">
                            <td colspan="6" class="p-8 text-center text-gray-500"> Nenhum aluno encontrado.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="alunos.links.length > 3" class="mt-6 flex justify-center">
                 <div class="flex flex-wrap -mb-1">
                    <template v-for="(link, key) in alunos.links" :key="key">
                        <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-2 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
                        <Link v-else
                            class="mr-1 mb-1 px-4 py-2 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500 transition"
                            :class="{ 'bg-blue-600 text-white border-blue-600': link.active }"
                            :href="link.url"
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>
    </TenantLayout>
</template>