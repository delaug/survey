export default {
    namespaced: true,
    state: () => ({
        user: null,
        token: null,
    }),
    getters: {
    },
    mutations: {
        SET_USER(state, payload) {
            state.user = payload
        },
        SET_TOKEN(state, payload) {
            state.token = payload
        },
    },
    actions: {
        login({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post('api/v1/login', payload)
                        .then(response => {
                            localStorage.setItem('token', response.data.token)
                            localStorage.setItem('user', JSON.stringify(response.data.user))
                            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token
                            commit('SET_USER', response.data.user)
                            commit('SET_TOKEN', response.data.token)

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
                            localStorage.setItem('token', response.data.token)
                            localStorage.setItem('user', JSON.stringify(response.data.user))
                            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token
                            commit('SET_USER', response.data.user)
                            commit('SET_TOKEN', response.data.token)

                            resolve(response);
                        })
                        .catch(error => {
                            reject(error);
                        })
                });
            })
        },
        logout({commit}) {
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            commit('SET_TOKEN', null)
            commit('SET_USER', null)
        }
    },
}
