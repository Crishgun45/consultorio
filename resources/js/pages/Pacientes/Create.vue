<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = ref({
    nombre: '',
    apellido_paterno: '',
    apellido_materno: '',
    telefono: '',
    email: '',
    fecha_nacimiento: '',
    direccion: '',
    historial_medico: '',
});

const guardarPaciente = () => {
    router.post('/pacientes', form.value);
};

const cancelar = () => {
    router.visit('/pacientes'); // Redirige a la lista de pacientes
};
</script>

<template>
    <Head title="Agregar Paciente" />
    <AppLayout>
        <div class="p-6 max-w-4xl mx-auto bg-gray-800 text-white rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Agregar Nuevo Paciente</h2>
            <form @submit.prevent="guardarPaciente">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block">Nombre:</label>
                        <input v-model="form.nombre" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Apellido Paterno:</label>
                        <input v-model="form.apellido_paterno" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Apellido Materno:</label>
                        <input v-model="form.apellido_materno" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Teléfono:</label>
                        <input v-model="form.telefono" type="tel" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Correo electrónico:</label>
                        <input v-model="form.email" type="email" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Fecha de Nacimiento:</label>
                        <input v-model="form.fecha_nacimiento" type="date" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Dirección:</label>
                        <input v-model="form.direccion" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block">Historial Médico:</label>
                        <textarea v-model="form.historial_medico" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white"></textarea>
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" @click="cancelar" class="bg-gray-600 px-4 py-2 rounded text-white">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-indigo-600 px-4 py-2 rounded text-white">
                        Guardar Paciente
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
