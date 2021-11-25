export default {
    namespaced: true,
    state: () => ({
        question_types: [],
    }),
    getters: {},
    mutations: {
        SET_QUESTION_TYPES(state, payload) {
            state.question_types = payload
        },
    },
    actions: {
        getQuestionTypes({commit}) {
            return new Promise((resolve, reject) => {
                window.axios.get('/sanctum/csrf-cookie').then(response => {
                    window.axios.get(`api/v1/admin/question-types`)
                        .then(response => {
                            commit('SET_QUESTION_TYPES', response.data)
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
