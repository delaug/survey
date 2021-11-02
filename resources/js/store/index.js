import {createStore} from 'vuex'
import auth from './modules/auth'
import surveys from './modules/surveys'

export default createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        surveys,
    }
})
