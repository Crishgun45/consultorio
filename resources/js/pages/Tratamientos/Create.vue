<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = ref({
    nombre: '',
    descripcion:'',
    costo:'',
});

const guardarTratamiento = () => {
    router.post('/tratamientos', form.value);
};

const cancelar = () => {
    router.visit('/tratamientos'); // Redirige a la lista de pacientes
};
</script>

<template>
    <Head title="Agregar Tratamiento" />
    <AppLayout>
        <div class="p-6 max-w-4xl mx-auto bg-gray-800 text-white rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Agregar Nuevo tratamiento</h2>
            <form @submit.prevent="guardarTratamiento">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block">Nombre:</label>
                        <input v-model="form.nombre" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Descripcion:</label>
                        <input v-model="form.descripcion" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Costo:</label>
                        <input v-model="form.costo" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" @click="cancelar" class="bg-gray-600 px-4 py-2 rounded text-white">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-indigo-600 px-4 py-2 rounded text-white">
                        Guardar tratamiento
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
