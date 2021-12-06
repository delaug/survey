import {notify, notifyErrors} from "../../../helpers";

export default {
    namespaced: true,
    state: () => ({
        surveys: [],
        survey: null,
        form: null,
        loading: false,
        id: null,

        current_page: 1,
        last_page: null,
    }),
    getters: {},
    mutations: {
        SET_SURVEYS(state, payload) {
            state.surveys = [...state.surveys, ...payload]
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
                media_id: null,
                is_publish: false,
                media: null,
            }

            if (payload) {
                this.dispatch('admin/surveys/getSurvey', payload)
                    .then(() => {
                        state.form = {
                            id: state.survey.id,
                            title: state.survey.title,
                            description: state.survey.description,
                            user_id: state.survey.user_id,
                            media_id: state.survey.media_id,
                            is_publish: state.survey.publish_at ? true : false,
                            media: state.survey.media,
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
        getSurveys({state, commit}) {
            if(state.last_page && state.current_page > state.last_page)
                return false;

            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/surveys?page=${state.current_page}`)
                        .then(response => {
                            commit('SET_SURVEYS', response.data.data)
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
