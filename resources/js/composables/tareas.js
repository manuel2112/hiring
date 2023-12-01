import axios from "axios";
import {ref} from "vue";
import { useRouter } from "vue-router";

export default function useTareas(){

    const tareas = ref([]);
    const tarea  = ref([]);
    const errors = ref('');
    const router = useRouter();

    // SIN PAGINACIÓN
    // const getTareas = async() => {

    //     const res = await axios.get('/api/tareas');
    //     tareas.value = res.data.data;
    // }
    const getTareas = async(page) => {

        const res = await axios.get(`/api/tareas?page=${page}`);
        tareas.value = res.data;
    }

    const getTarea = async(id) => {

        const res = await axios.get(`/api/tareas/${id}`);
        tarea.value = res.data.data;
    }
    
    const destroyTarea = async(id) => {

        await axios.delete(`/api/tareas/${id}`);
    }
    
    const storeTarea = async(data) => {

        errors.value = '';

        try {
            const resp = await axios.post('/api/tareas', data);
            console.log(resp)
            // await router.push({name: 'tarea.home'});
        } catch (e) {
            if( e.response.status === 422 ){
                errors.value = e.response.data.errors;
                console.log(errors.value)
            }
        }
        
    }
    
    const updateTarea = async(id) => {

        errors.value = '';

        try {
            await axios.put(`/api/tareas/${id}`, tarea.value);
            await router.push({name: 'tarea.home'});
        } catch (e) {
            if( e.response.status === 422 ){
                errors.value = e.response.data.errors;
                console.log(errors.value)
            }
        }
        
    }
    
    const updateFieldTarea = async(id) => {

        errors.value = '';

        try {
            const resp = await axios.patch(`/api/tareas/confirm/${id}`);
            console.log(resp)
            // await router.push({name: 'tarea.home'});
        } catch (e) {
            if( e.response.status === 422 ){
                errors.value = e.response.data.errors;
                console.log(errors.value)
            }
        }
        
    }



    return {
        tareas,
        tarea,
        getTareas,
        getTarea,
        destroyTarea,
        storeTarea,
        updateTarea,
        updateFieldTarea,
        errors
    }
}