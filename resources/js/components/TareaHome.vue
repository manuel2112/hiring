<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">TAREAS</li>
        </ol>
    </nav>

    <div class="text-end">        
        <router-link to="/tarea/create" class="btn btn-primary">CREAR TAREA</router-link>
        
        <!-- <router-link :to="{name: 'tarea.create'}" class="btn btn-primary">CREAR TAREA</router-link> -->
    </div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">TAREA</th>
                <th scope="col">FECHA</th>
                <th scope="col">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <template v-for="(item, idx) in tareas.data" :key="item.id">
                <tr>
                    <th scope="row">{{ ++idx }}</th>
                    <td>{{ item.titulo }}</td>
                    <td>{{ formatDate(item.fecha) }}</td>
                    <td>
                        <button type="button" class="btn btn-success" @click="confirmTarea(item.id)"><i class="fa-solid fa-check"></i></button>
                        <router-link :to="{name: 'tarea.edit', params: {id: item.id}}" class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i></router-link>
                        <button type="button" class="btn btn-danger" @click="deleteTarea(item.id)"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>

            </template>
        </tbody>
    </table>

    <div class="form-group">
        <Pagination 
            :data="tareas" 
            @pagination-change-page="getTareas" 
        />
    </div>

</template>

<script>
import useTareas from '../composables/tareas';
import { onMounted } from "vue";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Swal from 'sweetalert2';

    export default {
        components: {
            'Pagination': Bootstrap5Pagination
        },

        setup(){
            const { tareas, getTareas, destroyTarea, updateFieldTarea } = useTareas();

            onMounted( () => getTareas());

            const deleteTarea = (id) => {

                Swal.fire({
                        title: "¿ESTÁS SEGURO DE ELIMINAR ESTA TAREA?",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "ELIMINAR",
                        confirmButtonColor: "#FF0000",
                        cancelButtonText: "CANCELAR",
                        allowOutsideClick: false
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            await destroyTarea(id);
                            await getTareas();
                            Swal.fire("TAREA ELIMINADA!", "", "success");
                        }
                    }
                );
            }

            const confirmTarea = (id) => {

                Swal.fire({
                        title: "¿ESTÁS SEGURO DE CONFIRMAR ESTA TAREA?",
                        showDenyButton: false,
                        showCancelButton: true,
                        confirmButtonText: "CONFIRMAR",
                        confirmButtonColor: "#198754",
                        cancelButtonText: "CANCELAR",
                        allowOutsideClick: false
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            await updateFieldTarea(id);
                            await getTareas();
                            Swal.fire("TAREA REALIZADA!", "", "success");
                        }
                    }
                );
            }

            return {
                tareas,
                deleteTarea,
                getTareas,
                confirmTarea
            }
        },
        methods: {
            formatDate(dateString) {
                const date = new Date(dateString);
                    // Then specify how you want your dates to be formatted
                return new Intl.DateTimeFormat('default', {
                                                            weekday: 'long',
                                                            month: 'long',
                                                            day: 'numeric',
                                                            hour: 'numeric',
                                                            minute: 'numeric',
                                                            hourCycle: 'h23',
                                                            timeZone: 'America/Chicago'
                                                        }).format(date);
            }
        }

    }

</script>