<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue'; 
import StatusBadge from '@/Components/Ui/Shared/StatusBadge.vue';
import Pagination from '@/Components/Ui/Shared/Pagination.vue';
import debounce from 'lodash/debounce';
import Swal from 'sweetalert2';

const props = defineProps({
    alunos: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');

watch(search, debounce((value) => {
    router.get('/alunos', { search: value }, {
        preserveState: true,
        replace: true,
        only: ['alunos']
    });
}, 300));

const destroy = (aluno) => {
    const alunoId = aluno.id;

    if (!alunoId) {
        console.error("Erro fatal: ID do aluno está ausente.");
        Swal.fire('Erro!', 'Não foi possível identificar o aluno para exclusão.', 'error');
        return;
    }

    Swal.fire({
        title: `Excluir ${aluno.nome}?`,
        text: "O aluno será movido para a tixeira. Esta ação pode ser desfeita.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, Excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/alunos/${alunoId}`, {
                preserveState: true,
                onSuccess: () => {
                    Swal.fire('Excluído!', 'O aluno foi movido para a lixeira.', 'success');
                },
                onError: (errors) => {
                    console.error(errors);
                    Swal.fire('Falha!', 'Houve um erro ao tentar excluir o aluno.', 'error');
                }
            });
        }
    });
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
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
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
                            <th class="p-4 border-b font-semibold text-gray-600">Email</th>
                            <th class="p-4 border-b font-semibold text-gray-600">CPF</th>

                            <!-- NOVA COLUNA DO PLANO -->
                            <th class="p-4 border-b font-semibold text-gray-600">Plano</th>

                            <th class="p-4 border-b font-semibold text-gray-600">Status</th>
                            <th class="p-4 border-b font-semibold text-gray-600 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="aluno in alunos.data" :key="aluno.id" class="hover:bg-gray-50 border-b last:border-0">
                            <td class="p-4 text-gray-500 text-sm">#{{ aluno.id }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ aluno.nome }}</td>
                            <td class="p-4 text-gray-600">{{ aluno.email }}</td>
                            <td class="p-4 text-gray-600">{{ aluno.cpf }}</td>

                            <!-- MOSTRAR O NOME DO PLANO -->
                            <td class="p-4 text-gray-600">
                                {{ aluno.plano?.nome ?? '—' }}
                            </td>

                            <td class="p-4">
                                <StatusBadge :status="aluno.status" />
                            </td>

                            <td class="p-4 text-right flex justify-end gap-3">
                                <Link :href="`/alunos/${aluno.id}/edit`" 
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    Editar
                                </Link>
                                
                                <button @click="destroy(aluno)" 
                                    class="text-red-500 hover:text-red-700 font-medium text-sm">
                                    Excluir
                                </button>
                            </td>
                        </tr>

                        <tr v-if="alunos.data.length === 0">
                            <td colspan="7" class="p-8 text-center text-gray-500">
                                Nenhum aluno encontrado.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Pagination :links="alunos.links" />
        </div>
    </TenantLayout>
</template>
