import {notify, notifyErrors} from "../../../helpers";

export default {
    namespaced: true,
    state: () => ({
        fields: [],
        field: null,
        form: null,
        loading: false,
        id: null,

        current_page: 1,
        last_page: null,
    }),
    getters: {},
    mutations: {
        SET_FIELDS(state, payload) {
            state.fields = [...state.fields, ...payload]
        },
        SET_FIELD(state, payload) {
            state.field = payload
        },
        ADD_FIELD(state, payload) {
            state.fields = [payload, ...state.fields]
        },
        UPDATE_FIELD(state, payload) {
            state.fields = state.fields.map(s => s.id === payload.id ? payload : s)
        },
        REMOVE_FIELD(state, payload) {
            state.fields = state.fields.filter(f => f.id !== payload)
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
                question_id: null,
            }

            if (payload) {
                this.dispatch('admin/fields/getField', payload)
                    .then(() => {
                        state.form = {
                            id: state.field.id,
                            text: state.field.text,
                            sort: state.field.sort,
                            question_id: state.field.question_id,
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
        getFields({state, commit}) {
            if(state.last_page && state.current_page > state.last_page)
                return false;

            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/fields?page=${state.current_page}`)
                        .then(response => {
                            commit('SET_FIELDS', response.data.data)
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
        getField({state, commit}, id) {
            state.loading = true

            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/fields/${id}`)
                        .then(response => {
                            commit('SET_FIELD', response.data)
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
        postField({state, commit}) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post(`api/v1/admin/fields`, state.form)
                        .then(response => {
                            commit('ADD_FIELD', response.data)
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
        updateField({state, commit}, id) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.put(`api/v1/admin/fields/${id}`, state.form)
                        .then(response => {
                            commit('UPDATE_FIELD', response.data)
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
        deleteField({state, commit}, id) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.delete(`api/v1/admin/fields/${id}`)
                        .then(response => {
                            commit('REMOVE_FIELD', id)
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
