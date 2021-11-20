import {notify, notifyErrors} from "../../../helpers";

export default {
    namespaced: true,
    state: () => ({
        users: null,
        user: null,
        form: null,
        loading: false,
        id: null
    }),
    getters: {},
    mutations: {
        SET_USERS(state, payload) {
            state.users = payload
        },
        SET_USER(state, payload) {
            state.user = payload
        },
        ADD_USER(state, payload) {
            state.users = [payload, ...state.users]
        },
        UPDATE_USER(state, payload) {
            state.users = state.users.map(u => u.id === payload.id ? payload : u)
        },
        REMOVE_USER(state, payload) {
            state.users = state.users.filter(f => f.id !== payload)
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
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role_ids: [2]
            }

            this.dispatch('admin/roles/getRoles')

            if (payload) {
                this.dispatch('admin/users/getUser', payload)
                    .then(() => {
                        state.form = {
                            id: state.user.id,
                            name: state.user.name,
                            email: state.user.email,
                            password: state.user.password,
                            password_confirmation: state.user.password,
                            role_ids: state.user.roles.map(r => r.id)
                        }
                    });
            }
        },
        UPDATE_FORM_FIELD(state, payload) {
            state.form[payload.field] = payload.value
            if(payload.field === 'password')
                state.form['password_confirmation'] = payload.value
        },
    },
    actions: {
        getUsers({state, commit}) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/users`)
                        .then(response => {
                            commit('SET_USERS', response.data)
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
        getUser({state, commit}, id) {
            state.loading = true

            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/users/${id}`)
                        .then(response => {
                            commit('SET_USER', response.data)
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
        postUser({state, commit}) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post(`api/v1/admin/users`, state.form)
                        .then(response => {
                            commit('ADD_USER', response.data)
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
        updateUser({state, commit}, id) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.put(`api/v1/admin/users/${id}`, state.form)
                        .then(response => {
                            commit('UPDATE_USER', response.data)
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
        deleteUser({state, commit}, id) {
            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.delete(`api/v1/admin/users/${id}`)
                        .then(response => {
                            commit('REMOVE_USER', id)
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
