import {createStore} from 'vuex'
import auth from './modules/auth'
import survey from './modules/survey'
import surveys from './modules/surveys'

export default createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        survey,
        surveys,
    }
})
