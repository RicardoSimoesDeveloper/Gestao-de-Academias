<template>
    <CentralLayout title="Editar Academia">
        <div class="bg-white p-6 rounded shadow max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h2 class="text-lg font-bold text-gray-700">Dados da Unidade</h2>
                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded">Modo de Edição</span>
            </div>

            <form @submit.prevent="submit">
                
                <div class="mb-4">
                    <label class="block font-bold mb-1 text-gray-500">ID (Subdomínio)</label>
                    <input 
                        :value="tenant.id" 
                        disabled 
                        class="w-full border p-2 rounded bg-gray-100 text-gray-500 cursor-not-allowed"
                    >
                    <p class="text-xs text-gray-400 mt-1">O ID não pode ser alterado pois está vinculado ao banco de dados.</p>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-1">Nome da Academia</label>
                    <input v-model="form.nome" type="text" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
                    <div v-if="form.errors.nome" class="text-red-500 text-sm mt-1">{{ form.errors.nome }}</div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <Link href="/admin/academias" class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded hover:bg-gray-50">
                        Cancelar
                    </Link>
                    <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 disabled:opacity-50">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </CentralLayout>
</template>

<script setup>
import CentralLayout from '@/Layouts/CentralLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    tenant: Object
});

const form = useForm({
    nome: props.tenant.name,
});

const submit = () => {
    form.put(`/admin/academias/${props.tenant.id}`);
};
</script>