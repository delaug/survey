export default {
    namespaced: true,
    state: () => ({
        roles: [],
    }),
    getters: {},
    mutations: {
        SET_ROLES(state, payload) {
            state.roles = payload
        },
    },
    actions: {
        getRoles({commit}) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/roles`)
                        .then(response => {
                            commit('SET_ROLES', response.data)
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
        }
    },
}
