import {createStore} from 'vuex'
import auth from './modules/auth'
import surveys from './modules/surveys'
import answers from './modules/answers'
import questions from './modules/questions'

export default createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        surveys,
        answers,
        questions,
    }
})
