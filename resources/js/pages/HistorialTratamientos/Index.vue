<template>
    <Head title="Historial" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-200 mb-2 sm:mb-0">Lista de Tratamientos</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 shadow-md rounded-lg text-gray-200">
                    <thead>
                        <tr>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Nombre</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Motivo</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left hidden sm:table-cell">
                                Fecha Realización</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="historialtratamiento in props.historialtratamientos" :key="historialtratamiento.id" class="hover:bg-gray-700">
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700">{{ historialtratamiento.cita.paciente.nombre }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700">{{ historialtratamiento.cita.motivo }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 hidden sm:table-cell">{{ formatearFechaHora(historialtratamiento.fecha_realizacion)  }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 flex space-x-2">
                                <button class="bg-[#37597c] px-2 py-1 rounded text-white" @click="verHistorialTratamiento(historialtratamiento)">👁</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="modalVer" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-gray-900 text-gray-200 rounded-lg p-4 sm:p-6 max-w-md w-full shadow-lg">
                    <h2 class="text-2xl font-semibold text-indigo-500 mb-4">Detalles del Tratamiento</h2>

                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Motivo del Tratamiento:</p>
                            <p>{{ historialtratamientoSeleccionado?.cita.motivo }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Notas:</p>
                            <p>{{ historialtratamientoSeleccionado?.notas }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Fecha de Realización:</p>
                            <p>{{ formatearFechaHora(historialtratamientoSeleccionado?.fecha_realizacion )}}</p>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-white font-semibold w-full sm:w-auto" @click="modalVer = false">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Historial de Tratamientos', href: '/historialTratamientos' },
];

interface HistorialTratamiento {
    id: number;
    id_cita: number;
    fecha_realizacion: string;
    notas: string;
    cita: Cita;
}

interface Cita {
    motivo: string;
    paciente: Paciente;
}

interface Paciente {
    id: number;
    nombre: string;
    apellido_paterno: string;
    apellido_materno: string;
    fecha_nacimiento: string;
    direccion: string;
    telefono: string;
    email: string;
    historial_medico: string;
    created_at: string;
    updated_at: string;
}

const props = defineProps({
    historialtratamientos: {
        type: Array as () => HistorialTratamiento[],
        required: true,
    },
});

const modalVer = ref(false);
const historialtratamientoSeleccionado = ref<HistorialTratamiento | null>(null);

const verHistorialTratamiento = (tratamiento: HistorialTratamiento) => {
    historialtratamientoSeleccionado.value = tratamiento;
    modalVer.value = true;
};
const formatearFechaHora = (fechaHoraString: string): string => {
    const fechaHora = new Date(fechaHoraString);
    const dia = fechaHora.getDate().toString().padStart(2, '0');
    const mes = (fechaHora.getMonth() + 1).toString().padStart(2, '0');
    const anio = fechaHora.getFullYear().toString();
    const hora = fechaHora.getHours().toString().padStart(2, '0');
    const minutos = fechaHora.getMinutes().toString().padStart(2, '0');
    return `${dia}/${mes}/${anio} ${hora}:${minutos}`;
};
</script>
