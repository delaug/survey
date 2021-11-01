export default {
    namespaced: true,
    state: () => ({
        survey: null,
        loading: true
    }),
    getters: {},
    mutations: {
        SET_SURVEY(state, payload) {
            state.survey = payload
        },
        SET_LOADING(state, payload) {
            state.loading = payload
        },
    },
    actions: {
        getSurvey({commit}, id) {
            return new Promise((resolve, reject) => {
                commit('SET_LOADING', true)
                window.axios.get(`api/v1/surveys/${id}`)
                    .then(response => {
                        commit('SET_SURVEY', response.data)
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
                    .finally(() => {
                        commit('SET_LOADING', false)
                    })
            })
        },
        getLoading({commit}, loading) {
            commit('SET_LOADING', loading);
        }
    },
}
