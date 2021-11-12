import {createRouter, createWebHistory} from 'vue-router'
import Home from '../views/Home'
import About from '../views/About'
import Login from '../views/Login'
import Register from '../views/Register'
import Surveys from "../views/Surveys";
import SurveyDetail from "../views/SurveyDetail";

const routes = [
    {
        path: '/',
        name: 'Home',
        position: null,
        component: Home
    },
    {
        path: '/surveys',
        name: 'Surveys',
        position: 'left',
        component: Surveys
    },
    {
        path: '/surveys/:id',
        name: 'SurveyDetail',
        //position: 'left',
        component: SurveyDetail,
        //props: true,
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
