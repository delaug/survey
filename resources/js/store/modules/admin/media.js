import {notify, notifyErrors} from "../../../helpers";

export default {
    namespaced: true,
    state: () => ({
        media: null,
        loading: false,
    }),
    getters: {},
    mutations: {
        SET_MEDIA(state, payload) {
            state.media = payload
        },
        SET_LOADING(state, payload) {
            state.loading = payload
        },
    },
    actions: {
        postMedia({state, commit}, payload) {
            let formData = new FormData()
            formData.append('attachment', payload)

            state.loading = true
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.post(`api/v1/admin/media`, formData)
                        .then(response => {
                            commit('SET_MEDIA', response.data)
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
        }
    },
}
