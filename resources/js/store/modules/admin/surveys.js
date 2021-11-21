import {notify, notifyErrors} from "../../../helpers";

export default {
    namespaced: true,
    state: () => ({
        surveys: null,
        survey: null,
        form: null,
        loading: false,
        id: null
    }),
    getters: {},
    mutations: {
        SET_SURVEYS(state, payload) {
            state.surveys = payload
        },
        SET_SURVEY(state, payload) {
            state.survey = payload
        },
        ADD_SURVEY(state, payload) {
            state.surveys = [payload, ...state.surveys]
        },
        UPDATE_SURVEY(state, payload) {
            state.surveys = state.surveys.map(s => s.id === payload.id ? payload : s)
        },
        REMOVE_SURVEY(state, payload) {
            state.surveys = state.surveys.filter(f => f.id !== payload)
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
                title: '',
                description: '',
                user_id: null,
                is_publish: false,
            }

            if (payload) {
                this.dispatch('admin/surveys/getSurvey', payload)
                    .then(() => {
                        state.form = {
                            id: state.survey.id,
                            title: state.survey.title,
                            description: state.survey.description,
                            user_id: state.survey.user_id,
                            is_publish: state.survey.publish_at ? true : false,
                        }
                    });
            }
        },
        UPDATE_FORM_FIELD(state, payload) {
            state.form[payload.field] = payload.value
        },
    },
    actions: {
        getSurveys({state, commit}) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/surveys`)
                        .then(response => {
                            commit('SET_SURVEYS', response.data)
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
        getSurvey({state, commit}, id) {
            state.loading = true

            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/surveys/${id}`)
                        .then(response => {
                            commit('SET_SURVEY', response.data)
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
        postSurvey({state, commit}) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post(`api/v1/admin/surveys`, state.form)
                        .then(response => {
                            commit('ADD_SURVEY', response.data)
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
        updateSurvey({state, commit}, id) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.put(`api/v1/admin/surveys/${id}`, state.form)
                        .then(response => {
                            commit('UPDATE_SURVEY', response.data)
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
        deleteSurvey({state, commit}, id) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.delete(`api/v1/admin/surveys/${id}`)
                        .then(response => {
                            commit('REMOVE_SURVEY', id)
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
