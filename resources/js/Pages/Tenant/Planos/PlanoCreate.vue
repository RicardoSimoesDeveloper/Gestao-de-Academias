<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import TenantLayout from '@/Layouts/TenantLayout.vue';

const form = useForm({
    nome: '',
    descricao: '',
    preco: 0.01,
    duracao_dias: 30,
    ativo: true,
});

const submit = () => {
    form.post('/planos', {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Cadastrar Plano" />

    <TenantLayout title="Cadastrar Novo Plano">
        <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-8">

            <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">
                Informações do Plano
            </h3>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nome</label>
                        <input v-model="form.nome" type="text"
                            :class="{ 'border-red-500': form.errors.nome }"
                            class="w-full px-3 py-2 border rounded-lg" required>
                        <div v-if="form.errors.nome" class="text-xs text-red-500 mt-1">{{ form.errors.nome }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Duração (Dias)</label>
                        <input v-model.number="form.duracao_dias" type="number" min="1"
                            :class="{ 'border-red-500': form.errors.duracao_dias }"
                            class="w-full px-3 py-2 border rounded-lg" required>
                        <div v-if="form.errors.duracao_dias" class="text-xs text-red-500 mt-1">
                            {{ form.errors.duracao_dias }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Preço (R$)</label>
                        <input v-model.number="form.preco" type="number" step="0.01" min="0.01"
                            :class="{ 'border-red-500': form.errors.preco }"
                            class="w-full px-3 py-2 border rounded-lg" required>
                        <div v-if="form.errors.preco" class="text-xs text-red-500 mt-1">{{ form.errors.preco }}</div>
                    </div>

                    <div class="flex items-center pt-5">
                        <input id="ativo" v-model="form.ativo" type="checkbox"
                            class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="ativo" class="ml-2 text-sm font-semibold text-gray-700">Plano Ativo</label>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Descrição (Opcional)</label>
                        <textarea v-model="form.descricao" rows="3"
                            class="w-full px-3 py-2 border rounded-lg"></textarea>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t flex justify-end gap-3">
                    <Link href="/planos" class="px-6 py-3 text-gray-700 rounded-lg hover:bg-gray-100 font-semibold">
                        Cancelar
                    </Link>
                    <button type="submit" :disabled="form.processing"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 disabled:opacity-50">
                        {{ form.processing ? 'Salvando...' : 'Cadastrar Plano' }}
                    </button>
                </div>
            </form>

        </div>
    </TenantLayout>
</template>
