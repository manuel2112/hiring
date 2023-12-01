import './bootstrap';
import { createApp } from "vue";
import TareaInit from './components/TareaInit.vue';
import router from "./router"

const app = createApp(TareaInit);
app.use(router);
app.mount("#app-vue");