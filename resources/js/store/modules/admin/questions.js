import {notify, notifyErrors} from "../../../helpers";

export default {
    namespaced: true,
    state: () => ({
        questions: null,
        item_index: 0
    }),
    getters: {
        currentQuestion: (state) => {
            return state.questions ? state.questions[state.item_index] : null
        }
    },
    mutations: {
        SET_QUESTIONS(state, payload) {
            state.questions = payload
            if(payload && payload.length > 0)
                state.id = payload[0].id
        },
        ADD_QUESTION(state, payload) {
            state.questions = [...state.questions, payload]
        },
        UPDATE_QUESTION(state, payload) {
            state.questions = state.questions.map(s => s.id === payload.id ? payload : s)
        },
        REMOVE_QUESTION(state, payload) {
            if(payload.id)
                state.questions = state.questions.filter(f => f.id !== payload.id)
            else
                state.questions = state.questions.filter((_, index) => index != payload.index);

            state.item_index = (state.questions && state.questions.length > 0) ? state.questions.length - 1 : 0
        },
        SET_ITEM_INDEX(state, payload) {
            state.item_index = payload
        },
        NEW_QUESTION(state) {
            let template = {
                id: null,
                text: '',
                sort: 10,
                type_id: null,
                survey_id: null,
            }

            if(state.questions)
                state.questions = [...state.questions, template]
            else
                state.questions = [template]

            state.item_index = state.questions.length - 1
        }
    },
    actions: {
        getQuestionsBySurvey({state, commit}, id) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/surveys/${id}/questions`)
                        .then(response => {
                            commit('SET_QUESTIONS', response.data)
                            resolve(response);
                        })
                        .catch(error => {
                            if (error.request.status === 401) {
                                commit('auth/CLEAR_DATA', null, {root: true})
                            }
                            reject(error);
                        })
                })
            })
        },
        getQuestion({state, commit}, id) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/questions/${id}`)
                        .then(response => {
                            commit('UPDATE_QUESTION', response.data)
                            resolve(response);
                        })
                        .catch(error => {
                            if (error.request.status === 401) {
                                commit('auth/CLEAR_DATA', null, {root: true})
                            }

                            reject(error);
                        })
                })
            })
        },
        postQuestion({state, commit}) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post(`api/v1/admin/questions`, state.form)
                        .then(response => {
                            commit('ADD_QUESTION', response.data)
                            notify('Success','success')
                            resolve(response);
                        })
                        .catch(error => {
                            if (error.request.status === 401) {
                                commit('auth/CLEAR_DATA', null, {root: true})
                            }

                            notifyErrors(error.response.data.errors)

                            reject(error);
                        })
                })
            })
        },
        updateQuestion({state, commit}, id) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.put(`api/v1/admin/questions/${id}`, state.form)
                        .then(response => {
                            commit('UPDATE_QUESTION', response.data)
                            notify('Success','success')
                            resolve(response);
                        })
                        .catch(error => {
                            if (error.request.status === 401) {
                                commit('auth/CLEAR_DATA', null, {root: true})
                            }

                            notifyErrors(error.response.data.errors)

                            reject(error);
                        })
                })
            })
        },
        deleteQuestion({state, commit}, payload) {

            if(!payload.id)
                commit('REMOVE_QUESTION', payload)
            else
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.delete(`api/v1/admin/questions/${payload.id}`)
                        .then(response => {
                            commit('REMOVE_QUESTION', payload.id)
                            notify('Success','success')
                            resolve(response);
                        })
                        .catch(error => {
                            if (error.request.status === 401) {
                                commit('auth/CLEAR_DATA', null, {root: true})
                            }

                            if(error.response.data.message)
                                notify(error.response.data.message)

                            if(error.response.data.errors)
                                notifyErrors(error.response.data.errors)

                            reject(error);
                        })
                })
            })
        }
    },
}
