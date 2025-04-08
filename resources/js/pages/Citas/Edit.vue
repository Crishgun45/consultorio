<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

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

const pacientes = ref<Paciente[]>([]);
const tratamientos = ref<Tratamiento[]>([]);
const form = ref({
    id_paciente: 0,
    fecha_hora: '',
    motivo: '',
    estado: '',
});

const actualizarCita = () => {
    router.put(`/citas/${props.cita.id}`, form.value);
};

const cancelar = () => {
    router.visit('/citas');
};
onMounted(() => {
    pacientes.value = props.pacientes;
    tratamientos.value = props.tratamientos;

    // Formatear la fecha y hora a YYYY-MM-DDTHH:MM
    const fechaHora = new Date(props.cita.fecha_hora);
    const anio = fechaHora.getFullYear().toString().padStart(4, '0');
    const mes = (fechaHora.getMonth() + 1).toString().padStart(2, '0');
    const dia = fechaHora.getDate().toString().padStart(2, '0');
    const hora = fechaHora.getHours().toString().padStart(2, '0');
    const minutos = fechaHora.getMinutes().toString().padStart(2, '0');
    const fechaHoraFormateada = `${anio}-${mes}-${dia}T${hora}:${minutos}`;

    form.value = {
        id_paciente: props.cita.id_paciente,
        fecha_hora: fechaHoraFormateada, // Usar la fecha y hora formateada
        motivo: props.cita.motivo,
        estado: props.cita.estado,
    };
});



const props = defineProps({
    cita: {
        type: Object as () => Cita,
        required: true,
    },
    pacientes: {
        type: Array as () => Paciente[],
        required: true,
    },
    tratamientos: { // Añade prop para tratamientos
        type: Array as () => Tratamiento[],
        required: true,
    },
});
</script>

<template>
    <Head title="Editar Cita" />
    <AppLayout>
        <div class="p-6 max-w-4xl mx-auto bg-gray-800 text-white rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Editar Cita</h2>
            <form @submit.prevent="actualizarCita">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block">Paciente:</label>
                        <select v-model="form.id_paciente" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                            <option value="">Seleccione un paciente</option>
                            <option v-for="paciente in pacientes" :key="paciente.id" :value="paciente.id">
                                {{ paciente.nombre }} {{ paciente.apellido_paterno }} {{ paciente.apellido_materno }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block">Fecha y Hora:</label>
                        <input v-model="form.fecha_hora" type="datetime-local" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                    </div>
                    <div>
                        <label class="block">Motivo:</label>
                        <select v-model="form.motivo" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                            <option value="">Seleccione un tratamiento</option>
                            <option v-for="tratamiento in tratamientos" :key="tratamiento.id" :value="tratamiento.nombre">
                                {{ tratamiento.nombre }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block">Estado:</label>
                        <select v-model="form.estado" class="w-full p-2 rounded bg-gray-700 border border-gray-600 text-white" required>
                            <option value="">Seleccione un estado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Confirmada">Confirmada</option>
                            <option value="Cancelada">Cancelada</option>
                            <option value="Realizada">Realizada</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" @click="cancelar" class="bg-gray-600 px-4 py-2 rounded text-white">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-indigo-600 px-4 py-2 rounded text-white">
                        Actualizar Cita
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
