export default {
    namespaced: true,
    state: () => ({
        surveys: [],
        current_page: 0,
        last_page: null,
    }),
    getters: {},
    mutations: {
        SET_SURVEYS(state, payload) {
            state.surveys = [...state.surveys, ...payload]
        },
        SET_CURRENT_PAGE(state, payload) {
            state.current_page = payload
        },
        SET_LAST_PAGE(state, payload) {
            state.last_page = payload
        },
    },
    actions: {
        getSurveys({state, commit}) {
            if (state.last_page && state.current_page >= state.last_page)
                return false;

            return new Promise((resolve, reject) => {
                window.axios.get(`api/v1/surveys?page=${state.current_page + 1}`)
                    .then(response => {
                        commit('SET_SURVEYS', response.data.data)
                        commit('SET_CURRENT_PAGE', response.data.current_page)
                        commit('SET_LAST_PAGE', response.data.last_page)
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })

            })
        }
    },
}
