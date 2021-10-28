import {createRouter, createWebHistory} from 'vue-router'
import Home from '../views/Home'
import About from '../views/About'
import Login from '../views/Login'
import Register from '../views/Register'

const routes = [
    {
        path: '/',
        name: 'Home',
        position: 'left',
        component: Home
    },
    {
        path: '/about',
        name: 'About',
        position: 'left',
        component: About
    },
    {
        path: '/register',
        name: 'Sign Up',
        position: 'right',
        component: Register
    },
    {
        path: '/login',
        name: 'Sign In',
        position: 'right',
        component: Login
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router
