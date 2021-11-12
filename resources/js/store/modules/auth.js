export default {
    namespaced: true,
    state: () => ({
        user: null,
        token: null,
    }),
    getters: {},
    mutations: {
        SET_DATA(state, payload) {
            localStorage.setItem('token', payload.token)
            localStorage.setItem('user', JSON.stringify(payload.user))
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + payload.token
            state.user = payload.user
            state.token = payload.token
        },

        CLEAR_DATA(state) {
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            window.axios.defaults.headers.common['Authorization'] = null
            state.user = null
            state.token = null
        }
    },
    actions: {
        login({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post('api/v1/login', payload)
                        .then(response => {
                            commit('SET_DATA', response.data)
                            resolve(response);
                        })
                        .catch(error => {
                            reject(error);
                        })
                });
            })
        },
        register({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post('api/v1/register', payload)
                        .then(response => {
                            commit('SET_DATA', response.data)
                            resolve(response);
                        })
                        .catch(error => {
                            reject(error);
                        })
                });
            })
        },
        logout({commit}) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post('api/v1/logout', null)
                        .then(response => {
                            commit('CLEAR_DATA')
                            commit('surveys/CLEAR_ALL_ANSWERS_TO_QUESTIONS_COUNT', null, {root: true})
                            resolve(response);
                        })
                        .catch(error => {
                            if(error.request.status === 401) {
                                commit('CLEAR_DATA')
                                commit('surveys/CLEAR_ALL_ANSWERS_TO_QUESTIONS_COUNT', null, {root: true})
                            }
                            reject(error);
                        })
                });
            })
        }
    },
}
