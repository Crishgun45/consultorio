<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    paciente: {
        type: Object,
        required: true
    }
});

const form = ref({ ...props.paciente });

const actualizarPaciente = () => {
    router.put(`/pacientes/${form.value.id}`, form.value);
};
</script>

<template>
    <Head title="Editar Paciente" />
    <AppLayout>
        <div class="p-6 max-w-lg mx-auto bg-gray-800 text-white rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Editar Paciente</h2>
            <form @submit.prevent="actualizarPaciente">
                <div class="mb-3">
                    <label class="block">Nombre:</label>
                    <input v-model="form.nombre" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                </div>

                <div class="mb-3">
                    <label class="block">Apellido Paterno:</label>
                    <input v-model="form.apellido_paterno" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                </div>

                <div class="mb-3">
                    <label class="block">Teléfono:</label>
                    <input v-model="form.telefono" type="tel" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                </div>

                <div class="mb-3">
                    <label class="block">Historial Médico:</label>
                    <textarea v-model="form.historial_medico" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white"></textarea>
                </div>

                <button type="submit" class="bg-green-600 px-4 py-2 rounded text-white">
                    Actualizar Paciente
                </button>
            </form>
        </div>
    </AppLayout>
</template>
