<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue'; 
import Swal from 'sweetalert2'; 
import { defineProps } from 'vue';

const props = defineProps({
    planos: Object, // Paginator de Planos
});

// 🚨 Lógica de Exclusão (Soft Delete)
const destroy = (plano) => {
    Swal.fire({
        title: 'Excluir Plano?',
        text: `Tem certeza que deseja mover o plano "${plano.nome}" para a lixeira?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, Excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/planos/${plano.id}`, { 
                onSuccess: () => {
                    Swal.fire('Excluído!', 'O plano foi movido para a lixeira.', 'success');
                },
                onError: () => {
                    Swal.fire('Erro!', 'Não foi possível excluir o plano.', 'error');
                }
            });
        }
    });
};

// Formata o valor monetário com segurança
const formatCurrency = (value) => {
    const numericValue = parseFloat(value); 
    if (isNaN(numericValue)) return 'R$ 0,00';
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(numericValue);
};
</script>

<template>
    <Head title="Catálogo de Planos" />
    <TenantLayout title="Catálogo de Planos">
        <div class="bg-white shadow rounded-lg p-6">
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Planos de Adesão</h3>
                <Link href="/planos/create" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center transition">
                    + Novo Plano
                </Link>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium text-gray-600">Nome</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-600">Preço</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-600">Duração</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-600">Ativo</th>
                            <th class="p-4 text-right text-sm font-medium text-gray-600">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="plano in planos.data" :key="plano.id">
                            <td class="p-4 whitespace-nowrap font-medium text-gray-800">{{ plano.nome }}</td>
                            <td class="p-4 whitespace-nowrap text-gray-600">
                                {{ formatCurrency(plano.preco) }}
                            </td>
                            <td class="p-4 whitespace-nowrap text-gray-600">{{ plano.duracao_dias }} dias</td>
                            <td class="p-4 whitespace-nowrap">
                                <span 
                                    :class="plano.ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                >
                                    {{ plano.ativo ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link 
                                    :href="`/planos/${plano.id}/edit`" 
                                    class="text-blue-600 hover:text-blue-800 mr-4"
                                >
                                    Editar
                                </Link>
                                <button @click="destroy(plano)" class="text-red-600 hover:text-red-800">
                                    Excluir
                                </button>
                            </td>
                        </tr>

                        <tr v-if="planos.data.length === 0">
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                Nenhum plano cadastrado.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PAGINAÇÃO CORRIGIDA -->
            <div v-if="planos.links && planos.links.length > 3" class="mt-4">
                <template v-for="link in planos.links" :key="link.label">
                    <Link 
                        v-if="link.url"
                        :href="link.url"
                        v-html="link.label"
                        :class="{'bg-blue-600 text-white': link.active}"
                        class="px-3 py-1 mr-1 text-sm border rounded-lg hover:bg-gray-200"
                    />
                    <span 
                        v-else 
                        v-html="link.label"
                        class="px-3 py-1 mr-1 text-sm border rounded-lg text-gray-400"
                    />
                </template>
            </div>
        </div>
    </TenantLayout>
</template>
