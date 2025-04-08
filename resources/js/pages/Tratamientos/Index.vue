<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tratamientos',
        href: '/tratamientos',
    },
];

interface Tratamiento {
    id: number;
    nombre: string;
    descripcion: string;
    costo:number;
}

const props = defineProps({
    tratamientos: {
        type: Array as () => Tratamiento[],
        required: true,
    },
});

const modalVer = ref(false);
const tratamientoSeleccionado = ref<Tratamiento | null>(null);

const verTratamiento = (tratamiento: Tratamiento) => {
    tratamientoSeleccionado.value = tratamiento;
    modalVer.value = true;
};

const editarTratamiento = (tratamiento: Tratamiento) => {
    router.visit(`/tratamientos/${tratamiento.id}/edit`);
};

const eliminarTratamiento = (id: number) => {
    if (confirm("¿Estás seguro de eliminar este tratamiento?")) {
        router.delete(`/tratamientos/${id}`, {
            onSuccess: () => {
                console.log("Tratamiento eliminado exitosamente");
            },
            onError: (errors) => {
                console.error("Error al eliminar el tratamiento", errors);
            },
        });
    }
};

const agregarNuevoTratamiento = () => {
    router.visit('/tratamientos/create');
};
</script>

<template>

    <Head title="Tratamientos" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-200 mb-2 sm:mb-0">Lista de Tratamientos</h2>
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto"
                    @click="agregarNuevoTratamiento">
                    Agregar Nuevo Tratamiento
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 shadow-md rounded-lg text-gray-200">
                    <thead>
                        <tr>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Nombre</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left hidden sm:table-cell">
                                Descripcion</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left hidden sm:table-cell">
                                Costo</th>
                            <th class="bg-[#132333] py-2 px-4 border border-gray-700 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="tratamiento in props.tratamientos" :key="tratamiento.id" class="hover:bg-gray-700">
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700">{{ tratamiento.nombre }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 hidden sm:table-cell">{{
                                tratamiento.descripcion }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 hidden sm:table-cell">{{
                                tratamiento.costo }}</td>
                            <td class="bg-[#2a3c4d] py-2 px-4 border-b border-gray-700 flex space-x-2">
                                <button class="bg-[#37597c] px-2 py-1 rounded text-white"
                                    @click="verTratamiento(tratamiento)">👁</button>
                                <button class="bg-[#396fa5] px-2 py-1 rounded text-white"
                                    @click="editarTratamiento(tratamiento)">✏</button>
                                <button class="bg-[#b32b2b] px-2 py-1 rounded text-white"
                                    @click="eliminarTratamiento(tratamiento.id)">🗑</button>
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
                            <p class="font-semibold text-indigo-500">Nombre:</p>
                            <p>{{ tratamientoSeleccionado?.nombre }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Descripcion:</p>
                            <p>{{ tratamientoSeleccionado?.descripcion }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                            <p class="font-semibold text-indigo-500">Costo:</p>
                            <p>{{ tratamientoSeleccionado?.costo }}</p>
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
