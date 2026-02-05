import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import '../css/app.css'
import '@fortawesome/fontawesome-free/css/all.css'

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const token = document.head.querySelector('meta[name="csrf-token"]')
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}

const app = createApp(App)

app.use(router).mount('#app')