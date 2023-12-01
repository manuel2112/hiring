<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><router-link :to="{name: 'tarea.home'}">TAREAS</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">CREAR</li>
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
            <input v-model="form.titulo" type="text" name="titulo" class="form-control" placeholder="INGRESAR TÍTULO..." />
        </div>

        <div class="form-group">
            <label>Tarea</label>
            <textarea v-model="form.tarea" class="form-control" name="tarea" rows="3" placeholder="INGRESAR TAREA..."></textarea>
        </div>

        <div class="form-group">
            <label>Fecha</label>
            <VueDatePicker 
                v-model="form.fecha" 
                locale="es" 
                cancelText="CANCELAR" 
                selectText="ACEPTAR"
                format="MM/dd/yyyy HH:mm"
                placeholder="INGRESAR FECHA..."
            ></VueDatePicker>
        </div>
        
        <div class="form-group mt-2 text-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

    </form>

</template>

<script>
import { reactive } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import useTareas from '../composables/tareas';

    export default {
        components: {
            VueDatePicker
        },

        setup(){
            const { errors, storeTarea } = useTareas();
            
            const form = reactive({
                'titulo': '',
                'tarea': '',
                'fecha': '',
            });

            const saveTarea = async() => {
                await storeTarea({...form});
            }
            

            return {
                errors,
                form,
                saveTarea
            }
        }

    }

</script>