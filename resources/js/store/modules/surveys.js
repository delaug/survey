export default {
    namespaced: true,
    state: () => ({
        survey: null,
        surveys: [],
        current_page: 0,
        last_page: null,
    }),
    getters: {
        getQuestionById: (state) => id => {
            return state.survey.questions.find(q => q.id === id)
        },
        isDone: (state) => id => {
            const r = state.surveys.find(s => s.id === id)
            return r.answers_to_questions_count >= r.questions_count ? true : false
        },
        surveyIsDone: (state) => {
            return !state.survey || state.survey.answers_to_questions_count >= state.survey.questions_count ? true : false
        }
    },
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
        SET_ANSWERS_TO_QUESTIONS_COUNT(state, payload) {
            state.survey.answers_to_questions_count = payload
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
                        if(error.request.status === 401) {
                            commit('auth/CLEAR_DATA',null,{root:true})
                        }
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
                        if(error.request.status === 401) {
                            commit('auth/CLEAR_DATA',null,{root:true})
                        }
                        reject(error);
                    })
            })
        }
    },
}
