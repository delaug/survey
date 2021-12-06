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
import admFields from "./modules/admin/fields";
import admMedia from "./modules/admin/media";

const admin = {
    namespaced: true,
    modules: {
        'users': admUsers,
        'roles': admRoles,
        'surveys': admSurveys,
        'questions': admQuestions,
        'question_types': admQuestionTypes,
        'fields': admFields,
        'media': admMedia,
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
