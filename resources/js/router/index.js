import {createRouter, createWebHistory} from 'vue-router'
import Home from '../views/Home'
import About from '../views/About'
import Login from '../views/Login'
import Register from '../views/Register'
import Surveys from "../views/Surveys";
import SurveyDetail from "../views/SurveyDetail";
import Dashboard from "../views/Admin/Dashboard";

import AccessDenied from "../views/Admin/AccessDenied";
import AdminSurveys from "../views/Admin/Surveys";

import store from '../store'

import isAdmin from "../middleware/admin";
import Admin from "../components/Admin/Admin";
import Users from "../views/Admin/Users";

const adminMenu = {
    path: '/admin',
    name: 'admin',
    component: Admin,
    meta: {
        menu: 'admin',
        title: 'Admin',
        middleware: [isAdmin]
    },
    children: [
        {
            path: 'dashboard',
            name: 'admin.dashboard',
            meta: {
                menu: 'admin',
                title: 'Dashboard',

            },
            component: Dashboard
        },
        {
            path: 'users',
            name: 'admin.users',
            meta: {
                menu: 'admin',
                title: 'Users',

            },
            component: Users
        },
        {
            path: 'surveys',
            name: 'admin.surveys',
            meta: {
                menu: 'admin',
                title: 'Surveys',
            },
            component: AdminSurveys
        }
    ]
}

const routes = [
    {
        path: '/admin/access-denied',
        name: 'AccessDenied',
        component: AccessDenied,
    },
    {
        path: '/',
        name: 'home',
        position: null,
        component: Home
    },
    {
        path: '/surveys',
        name: 'surveys',
        position: 'left',
        component: Surveys
    },
    {
        path: '/surveys/:id',
        name: 'survey.detail',
        //position: 'left',
        component: SurveyDetail,
        //props: true,
    },
    {
        path: '/about',
        name: 'about',
        position: 'left',
        component: About
    },
    {
        path: '/register',
        name: 'sign-up',
        position: 'right',
        component: Register
    },
    {
        path: '/login',
        name: 'sign-in',
        position: 'right',
        component: Login
    },
    adminMenu
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

// Creates a `nextMiddleware()` function which not only
// runs the default `next()` callback but also triggers
// the subsequent Middleware function.
function nextFactory(context, middleware, index) {
    const subsequentMiddleware = middleware[index];
    // If no subsequent Middleware exists,
    // the default `next()` callback is returned.
    if (!subsequentMiddleware)
        return context.next;
    else
    return (...parameters) => {
        // Run the default Vue Router `next()` callback first.
        context.next(...parameters);
        // Then run the subsequent Middleware with a new
        // `nextMiddleware()` callback.
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({...context, next: nextMiddleware});
    };
}

router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware) ? to.meta.middleware : [to.meta.middleware];
        const context = {from, next, to, router, store};
        const nextMiddleware = nextFactory(context, middleware, 1);

        return middleware[0]({...context, next: nextMiddleware});
    } else
        return next();
});

export default router
