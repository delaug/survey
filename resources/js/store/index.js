import {createStore} from 'vuex'
import auth from './modules/auth'
import surveys from './modules/surveys'
import answers from './modules/answers'
import questions from './modules/questions'
import admUsers from "./modules/admin/users";
import admRoles from "./modules/admin/roles";
import admSurveys from "./modules/admin/surveys";

const admin = {
    namespaced: true,
    modules: {
        'users': admUsers,
        'roles': admRoles,
        'surveys': admSurveys
    }
}

export default createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        surveys,
        answers,
        questions,
        admin
    }
})
