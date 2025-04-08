<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Citas',
        href: '/citas',
    },
];
const formatearFechaHora = (fechaHoraString: string): string => {
    const fechaHora = new Date(fechaHoraString);
    const dia = fechaHora.getDate().toString().padStart(2, '0');
    const mes = (fechaHora.getMonth() + 1).toString().padStart(2, '0');
    const anio = fechaHora.getFullYear().toString();
    const hora = fechaHora.getHours().toString().padStart(2, '0');
    const minutos = fechaHora.getMinutes().toString().padStart(2, '0');
    return `${dia}/${mes}/${anio} ${hora}:${minutos}`;
};
interface Tratamiento {
    id: number;
    nombre: string;
    descripcion: string;
    precio: number;
    created_at: string;
    updated_at: string;
    pivot: {
        id_cita: number;
        id_tratamiento: number;
        fecha_realizacion: string;
        notas: string;
    };
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

interface Cita {
    id: number;
    id_paciente: number;
    fecha_hora: string;
    motivo: string;
    estado: string;
    paciente: Paciente;
    tratamientos: Tratamiento[];
}

const props = defineProps({
    citas: {
        type: Array as () => Cita[],
        required: true,
    },
});

const modalVer = ref(false);
const citaSeleccionada = ref<Cita | null>(null);

const verCita = (cita: Cita) => {
    citaSeleccionada.value = cita;
    modalVer.value = true;
};

const editarCita = (cita: Cita) => {
    router.visit(`/citas/${cita.id}/edit`);
};

const eliminarCita = (id: number) => {
    if (confirm("¿Estás seguro de eliminar este paciente?")) {
        router.delete(`/citas/${id}`, {
            onSuccess: () => {
                console.log("Paciente eliminado exitosamente");
            },
            onError: (errors) => {
                console.error("Error al eliminar el paciente", errors);
            },
        });
    }
};

const agregarNuevaCita = () => {
    router.visit('/citas/create');
};
</script>

<template>
    <Head title="Citas" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-200 mb-2 sm:mb-0">Citas</h2>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto"
                    @click="agregarNuevaCita">
                    Agregar Nueva Cita
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 shadow-md rounded-lg text-gray-200">
                    <thead>
                        <tr>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Paciente</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left hidden sm:table-cell">
                                Fecha</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left hidden sm:table-cell">
                                Estado</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left hidden sm:table-cell">
                                Tratamiento</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cita in props.citas" :key="cita.id" class="hover:bg-gray-700">
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700">{{ cita.paciente.nombre }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 hidden sm:table-cell">
                                {{ formatearFechaHora(cita.fecha_hora) }}
                            </td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 hidden sm:table-cell">{{
                                cita.estado }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 hidden sm:table-cell">
                                <span v-if="cita.tratamientos && cita.tratamientos.length > 0">
                                    {{ cita.tratamientos[0].nombre }}
                                </span>
                                <span v-else>{{ cita.motivo }}</span>
                            </td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 flex space-x-2">
                                <button class="bg-[#37597c] px-2 py-1 rounded text-white" @click="verCita(cita)">
                                    👁
                                </button>
                                <button class="bg-[#396fa5] px-2 py-1 rounded text-white"
                                    @click="editarCita(cita)">✏</button>
                                <button class="bg-[#b32b2b] px-2 py-1 rounded text-white"
                                    @click="eliminarCita(cita.id)">🗑</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="modalVer" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-gray-900 text-gray-200 rounded-lg p-4 sm:p-6 max-w-md w-full shadow-lg">
                    <h2 class="text-2xl font-semibold text-indigo-500 mb-4">Detalles de la Cita</h2>

                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Paciente:</p>
                            <p>{{ citaSeleccionada?.paciente?.nombre }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Motivo:</p>
                            <p>{{ citaSeleccionada?.motivo }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Fecha y Hora:</p>
                            <p>{{ formatearFechaHora(citaSeleccionada?.fecha_hora || '') }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Estado:</p>
                            <p>{{ citaSeleccionada?.estado }}</p>
                        </div>
                        <div v-if="citaSeleccionada?.tratamientos && citaSeleccionada.tratamientos.length > 0">
                            <p class="font-semibold text-indigo-500">Tratamientos:</p>
                            <ul>
                                <li v-for="tratamiento in citaSeleccionada.tratamientos" :key="tratamiento.id">
                                    {{ tratamiento.nombre }} - {{ tratamiento.pivot.fecha_realizacion }}
                                </li>
                            </ul>
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

