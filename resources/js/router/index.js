import { createRouter, createWebHistory } from 'vue-router'

// страницы
import Passengers from '../views/Passengers.vue'

const routes = [
    { path: '/', name: 'Passengers', component: Passengers }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
