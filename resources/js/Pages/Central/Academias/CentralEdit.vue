<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import SuccessModal from '@/Components/Ui/Shared/SuccessModal.vue'; 

const props = defineProps({
    tenant: Object
});

const showModal = ref(false);

const form = useForm({
    nome: props.tenant.name,
});

const salvarCadastro = () => {
    const id = String(props.tenant.id).trim();
    const urlFinal = `/admin/academias/${id}`;

    form.put(urlFinal, {
        onSuccess: () => {
            showModal.value = true;
        },
        onError: (errors) => {
            console.error('Erro ao salvar:', errors);
        }
    });
};

const fecharModal = () => {
    showModal.value = false;
};
</script>

<template>
    <CentralLayout title="Editar Academia">
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-3xl mx-auto">
            
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Dados da Unidade</h2>
                    <p class="text-sm text-gray-400 mt-1">Atualize as informações cadastrais da franquia.</p>
                </div>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold tracking-wide uppercase">
                    {{ tenant.id }}
                </span>
            </div>

            <form @submit.prevent="salvarCadastro">
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">ID do Sistema (Subdomínio)</label>
                    <div class="relative">
                        <input 
                            :value="tenant.id" 
                            disabled 
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-500 cursor-not-allowed font-mono text-sm"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Este identificador é único e não pode ser alterado.</p>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nome da Academia</label>
                    <input 
                        v-model="form.nome" 
                        type="text" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all"
                        placeholder="Ex: Gold Gym Unidade 1"
                    >
                    <div v-if="form.errors.nome" class="text-red-500 text-sm mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ form.errors.nome }}
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                    <Link 
                        href="/admin/academias" 
                        class="px-5 py-2.5 text-gray-600 hover:text-gray-900 font-medium hover:bg-gray-50 rounded-lg transition-colors"
                    >
                        Cancelar
                    </Link>
                    
                    <button 
                        type="submit" 
                        :disabled="form.processing" 
                        class="flex items-center bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 font-medium shadow-sm hover:shadow transition-all disabled:opacity-70 disabled:cursor-wait"
                    >
                        <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>{{ form.processing ? 'Salvando...' : 'Salvar Alterações' }}</span>
                    </button>
                </div>
            </form>
        </div>

        <SuccessModal :show="showModal" @close="fecharModal">
            <template #title>Atualização Concluída!</template>
            <p class="text-gray-500 mb-6">Os dados da academia foram atualizados corretamente.</p>
        </SuccessModal>

    </CentralLayout>
</template>