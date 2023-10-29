
import './assets/css/bootstrap.min.css'
import './assets/js/bootstrap.bundle.min.js'
import { createApp } from 'vue';
import App from './App.vue';
import router from './router'
import axios from 'axios'

window.axios = axios


const app = createApp(App)

app.use(router)
app.mount('#app')
