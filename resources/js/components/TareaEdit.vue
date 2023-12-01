<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link :to="{name: 'tarea.home'}">TAREAS</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">EDITAR</li>
        </ol>
    </nav>

    <div v-if=" errors != '' ">
        <div class="alert alert-danger">
            <div v-for="(v,k) in errors" :key="k">
                <p v-for="error in v" :key="error">
                     - {{ error }}
                </p>
            </div>
        </div>
    </div>

    <form @submit.prevent="saveTarea">

        <div class="form-group">
            <label>Título</label>
            <input v-model="tarea.titulo" type="text" name="titulo" class="form-control" />
        </div>

        <div class="form-group">
            <label>Tarea</label>
            <textarea v-model="tarea.tarea" class="form-control" name="tarea" rows="3" placeholder="INGRESAR TAREA..."></textarea>
        </div>

        <div class="form-group">
            <label>Fecha</label>
            <VueDatePicker 
                v-model="tarea.fecha" 
                locale="es" 
                cancelText="CANCELAR" 
                selectText="ACEPTAR"
                format="MM/dd/yyyy HH:mm"
                placeholder="INGRESAR FECHA..."
                timezone="America/Chicago"
            ></VueDatePicker>
            <!-- <input v-model="tarea.fecha" type="date" name="fecha" class="form-control" /> -->
        </div>
        
        <div class="form-group mt-2 text-end">
            <button type="submit" class="btn btn-primary">Editar</button>
        </div>

    </form>

</template>

<script>
import { onMounted } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import useTareas from '../composables/tareas';

    export default {
        components: {
            VueDatePicker
        },

        props: {
            id: {
                require: true,
                type: String
            }
        },

        setup(props){
            const { errors, tarea, getTarea, updateTarea } = useTareas();

            onMounted( () => getTarea(props.id));

            const saveTarea = async() => {
                await updateTarea(props.id);
            }
            

            return {
                tarea,
                errors,
                saveTarea
            }
        }

    }

</script>