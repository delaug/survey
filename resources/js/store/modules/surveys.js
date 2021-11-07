export default {
    namespaced: true,
    state: () => ({
        survey: null,
        surveys: [],
        current_page: 0,
        last_page: null,
    }),
    getters: {},
    mutations: {
        SET_SURVEY(state, payload) {
            state.survey = payload
        },
        CLEAR_SURVEYS(state) {
            state.surveys = []
        },
        SET_SURVEYS(state, payload) {
            state.surveys = [...state.surveys, ...payload]
        },
        SET_CURRENT_PAGE(state, payload) {
            state.current_page = payload
        },
        SET_LAST_PAGE(state, payload) {
            state.last_page = payload
        },
        UPDATE_SURVEY_QUESTION(state, payload) {
            // Find question and replace by id
            state.survey.questions = state.survey.questions.map(p => p.id === payload.id ? payload : p)
        }
    },
    actions: {
        getSurvey({commit}, id) {
            return new Promise((resolve, reject) => {
                window.axios.get(`api/v1/surveys/${id}`)
                    .then(response => {
                        commit('SET_SURVEY', response.data)
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
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
        },
        takeSurvey({state}, id) {
            if(!id)
                return false;

            return new Promise((resolve, reject) => {
                window.axios.post(`api/v1/surveys/${id}/take`)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    },
}
