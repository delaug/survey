import {createStore} from 'vuex'
import auth from './modules/auth'
import surveys from './modules/surveys'
import answers from './modules/answers'
import questions from './modules/questions'
import admUsers from "./modules/admin/users";
import admRoles from "./modules/admin/roles";
import admSurveys from "./modules/admin/surveys";
import admQuestions from "./modules/admin/questions";
import admQuestionTypes from "./modules/admin/question_types";

const admin = {
    namespaced: true,
    modules: {
        'users': admUsers,
        'roles': admRoles,
        'surveys': admSurveys,
        'questions': admQuestions,
        'question_types': admQuestionTypes,
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
