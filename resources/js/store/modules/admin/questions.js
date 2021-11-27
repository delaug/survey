import {notify, notifyErrors} from "../../../helpers";

export default {
    namespaced: true,
    state: () => ({
        questions: [],
        question: null,
        form: null,
        loading: false,
        id: null,

        current_page: 1,
        last_page: null,
    }),
    getters: {},
    mutations: {
        SET_QUESTIONS(state, payload) {
            state.questions = [...state.questions, ...payload]
        },
        SET_QUESTION(state, payload) {
            state.question = payload
        },
        ADD_QUESTION(state, payload) {
            state.questions = [payload, ...state.questions]
        },
        UPDATE_QUESTION(state, payload) {
            state.questions = state.questions.map(s => s.id === payload.id ? payload : s)
        },
        REMOVE_QUESTION(state, payload) {
            state.questions = state.questions.filter(f => f.id !== payload)
        },
        SET_FORM(state, payload) {
            state.form = payload
        },
        CLEAR_FORM(state) {
            state.form = null
        },
        SET_LOADING(state, payload) {
            state.loading = payload
        },
        SET_ID(state, payload) {
            state.id = payload

            // Create struct
            state.form = {
                id: null,
                text: '',
                sort: 10,
                type_id: null,
                survey_id: null,
            }

            if (payload) {
                this.dispatch('admin/questions/getQuestion', payload)
                    .then(() => {
                        state.form = {
                            id: state.question.id,
                            text: state.question.text,
                            sort: state.question.sort,
                            type_id: state.question.type_id,
                            survey_id: state.question.survey_id,
                        }
                    });
            }
        },
        UPDATE_FORM_FIELD(state, payload) {
            state.form[payload.field] = payload.value
        },

        SET_CURRENT_PAGE(state, payload) {
            state.current_page = payload + 1
        },
        SET_LAST_PAGE(state, payload) {
            state.last_page = payload
        },
    },
    actions: {
        getQuestions({state, commit}) {
            if(state.last_page && state.current_page > state.last_page)
                return false;

            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/questions?page=${state.current_page}`)
                        .then(response => {
                            commit('SET_QUESTIONS', response.data.data)
                            commit('SET_CURRENT_PAGE', response.data.current_page)
                            commit('SET_LAST_PAGE', response.data.last_page)
                            resolve(response);
                        })
                        .catch(error => {
                            if (error.request.status === 401) {
                                commit('auth/CLEAR_DATA', null, {root: true})
                            }
                            reject(error);
                        })
                        .finally(() => {
                            commit('SET_LOADING', false)
                        })
                })
            })
        },
        getQuestion({state, commit}, id) {
            state.loading = true

            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/questions/${id}`)
                        .then(response => {
                            commit('SET_QUESTION', response.data)
                            resolve(response);
                        })
                        .catch(error => {
                            if (error.request.status === 401) {
                                commit('auth/CLEAR_DATA', null, {root: true})
                            }

                            reject(error);
                        })
                        .finally(() => {
                            commit('SET_LOADING', false)
                        })
                })
            })
        },
        postQuestion({state, commit}) {
            state.loading = true
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
                        .finally(() => {
                            commit('SET_LOADING', false)
                        })
                })
            })
        },
        updateQuestion({state, commit}, id) {
            state.loading = true
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
                        .finally(() => {
                            commit('SET_LOADING', false)
                        })
                })
            })
        },
        deleteQuestion({state, commit}, id) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.delete(`api/v1/admin/questions/${id}`)
                        .then(response => {
                            commit('REMOVE_QUESTION', id)
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
                        .finally(() => {
                            commit('SET_LOADING', false)
                        })
                })
            })
        }
    },
}
