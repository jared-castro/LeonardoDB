import { createRouter, createWebHistory } from 'vue-router'
import Login from '../pages/Login.vue'
import Registro from '../pages/Registro.vue'
import LeonardoProyectos from '../pages/LeonardoProyectos.vue'
import LeonardoData from '../pages/LeonardoData.vue'
import LeonardoIA from '../pages/LeonardoIA.vue'
import LeonardoAPI from '../pages/LeonardoAPI.vue'
import LeonardoIA2 from '../pages/LeonardoIA2.vue'
import PreguntasLeonardo from '../pages/PreguntasLeonardo.vue'
const routes = [
    {
        path: '/',
        redirect: '/login'
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/registro',
        name: 'Registro',
        component: Registro
    },
    {
        path: '/leonardoproyectos',
        name: 'LeonardoProyectos',
        component: LeonardoProyectos,
        meta: { requiresAuth: true }
    },
{
    path: '/leonardodata/:id',
    name: 'LeonardoData',
    component: LeonardoData,
    meta: { requiresAuth: true }
},
{
    path: '/leonardoIA',
    name: 'LeonardoIA',
    component: LeonardoIA,
    meta: { requiresAuth: true }
},
{
    path: '/leonardoAPI',
    name: 'LeonardoAPI',
    component: LeonardoAPI,
    meta: { requiresAuth: true }
},
{
    path: '/leonardoIA2/:id',
    name: 'LeonardoIA2',
    component: LeonardoIA2,
    meta: { requiresAuth: true }
},
{
    path: '/PreguntasLeonardo',
    name: 'preguntasleonardo',
    component: PreguntasLeonardo,
    meta: { requiresAuth: true }
},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token')
    
    if (to.meta.requiresAuth && !token) {
        next('/login')
    } else {
        next()
    }
})

export default router