<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pacientes',
        href: '/pacientes',
    },
];

interface Paciente {
    id: number;
    nombre: string;
    apellido_paterno: string;
    telefono: string;
    email: string;
    direccion: string;
    fecha_nacimiento: string;
    historial_medico?: string;
}

const props = defineProps({
    pacientes: {
        type: Array as () => Paciente[],
        required: true,
    },
});

const modalVer = ref(false);
const pacienteSeleccionado = ref<Paciente | null>(null);

const verPaciente = (paciente: Paciente) => {
    pacienteSeleccionado.value = paciente;
    modalVer.value = true;
};

const editarPaciente = (paciente: Paciente) => {
    router.visit(`/pacientes/${paciente.id}/edit`);
};

const eliminarPaciente = (id: number) => {
    if (confirm("¿Estás seguro de eliminar este paciente?")) {
        router.delete(`/pacientes/${id}`, {
            onSuccess: () => {
                console.log("Paciente eliminado exitosamente");
            },
            onError: (errors) => {
                console.error("Error al eliminar el paciente", errors);
            },
        });
    }
};

const agregarNuevoPaciente = () => {
    router.visit('/pacientes/create');
};
</script>

<template>

    <Head title="Pacientes" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-200 mb-2 sm:mb-0">Lista de Pacientes</h2>
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto"
                    @click="agregarNuevoPaciente">
                    Agregar Nuevo Paciente
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 shadow-md rounded-lg text-gray-200">
                    <thead>
                        <tr>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Nombre</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left hidden sm:table-cell">
                                Apellido</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left hidden sm:table-cell">
                                Teléfono</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="paciente in props.pacientes" :key="paciente.id" class="hover:bg-gray-700">
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700">{{ paciente.nombre }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 hidden sm:table-cell">{{
                                paciente.apellido_paterno }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 hidden sm:table-cell">{{
                                paciente.telefono }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 flex space-x-2">
                                <button class="bg-[#37597c] px-2 py-1 rounded text-white"
                                    @click="verPaciente(paciente)">👁</button>
                                <button class="bg-[#396fa5] px-2 py-1 rounded text-white"
                                    @click="editarPaciente(paciente)">✏</button>
                                <button class="bg-[#b32b2b] px-2 py-1 rounded text-white"
                                    @click="eliminarPaciente(paciente.id)">🗑</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="modalVer" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-gray-900 text-gray-200 rounded-lg p-4 sm:p-6 max-w-md w-full shadow-lg">
                    <h2 class="text-2xl font-semibold text-indigo-500 mb-4">Detalles del Paciente</h2>

                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Nombre:</p>
                            <p>{{ pacienteSeleccionado?.nombre }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Apellido:</p>
                            <p>{{ pacienteSeleccionado?.apellido_paterno }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Teléfono:</p>
                            <p>{{ pacienteSeleccionado?.telefono }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Dirección:</p>
                            <p>{{ pacienteSeleccionado?.direccion }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Fecha de Nacimiento:</p>
                            <p>{{ pacienteSeleccionado?.fecha_nacimiento }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Correo:</p>
                            <p>{{ pacienteSeleccionado?.email }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Historial Médico:</p>
                            <p>{{ pacienteSeleccionado?.historial_medico }}</p>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button
                            class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-white font-semibold w-full sm:w-auto"
                            @click="modalVer = false">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
