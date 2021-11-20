import {createStore} from 'vuex'
import auth from './modules/auth'
import surveys from './modules/surveys'
import answers from './modules/answers'
import questions from './modules/questions'
import users from "./modules/admin/users";
import roles from "./modules/admin/roles";

const admin = {
    namespaced: true,
    modules: {
        users,
        roles
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
