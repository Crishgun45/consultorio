<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    tratamiento: {
        type: Object,
        required: true
    }
});

const form = ref({ ...props.tratamiento });

const actualizarTratamiento = () => {
    router.put(`/tratamientos/${form.value.id}`, form.value);
};
</script>

<template>
    <Head title="Editar tratamiento" />
    <AppLayout>
        <div class="p-6 max-w-lg mx-auto bg-gray-800 text-white rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Editar Tratamiento</h2>
            <form @submit.prevent="actualizarTratamiento">
                <div class="mb-3">
                    <label class="block">Nombre:</label>
                    <input v-model="form.nombre" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                </div>

                <div class="mb-3">
                    <label class="block">Descripcion:</label>
                    <input v-model="form.descripcion" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                </div>

                <div class="mb-3">
                    <label class="block">Costo:</label>
                    <input v-model="form.costo" type="tel" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                </div>

                <button type="submit" class="bg-green-600 px-4 py-2 rounded text-white">
                    Actualizar Tratamiento
                </button>
            </form>
        </div>
    </AppLayout>
</template>
