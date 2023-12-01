import axios from "axios";
import {ref} from "vue";
import { useRouter } from "vue-router";
import Swal from 'sweetalert2';

export default function useTareas(){

    const tareas = ref([]);
    const tarea  = ref([]);
    const errors = ref('');
    const router = useRouter();
    const user_id = document.querySelector("meta[name='user_id']").getAttribute('content');

    // SIN PAGINACIÓN
    // const getTareas = async() => {

    //     const res = await axios.get('/api/tareas');
    //     tareas.value = res.data.data;
    // }
    const getTareas = async(page) => {

        const res = await axios.get(`/api/tareas?page=${page}`, {
            params: {
              user_id
            }
          });
        tareas.value = res.data;
    }

    const getTarea = async(id) => {

        const res = await axios.get(`/api/tareas/${id}`);

        if( res.data.data.user_id != user_id ){
            Swal.fire("PERMISO DENEGADO", "USTED NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN", "error");
            await router.push({name: 'tarea.home'});
        }
        tarea.value = res.data.data;
    }
    
    const destroyTarea = async(id) => {

        await axios.delete(`/api/tareas/${id}`);
    }
    
    const storeTarea = async(data) => {

        data.user_id = user_id;
        errors.value = '';

        try {
            await axios.post('/api/tareas', data);
            await router.push({name: 'tarea.home'});
        } catch (e) {
            if( e.response.status === 422 ){
                errors.value = e.response.data.errors;
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

        Swal.showLoading();

        errors.value = '';

        try {
            const resp = await axios.patch(`/api/tareas/confirm/${id}`);
            await router.push({name: 'tarea.home'});
        } catch (e) {
            console.log(e)
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
        errors,
        user_id
    }
}