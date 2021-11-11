export default {
    namespaced: true,
    state: () => ({
        questions: []
    }),
    getters: {},
    mutations: {
        SET_QUESTIONS(state, payload) {
            state.questions = payload
        },
        UPDATE_QUESTION(state, payload) {
            state.questions = state.questions.map(e => e.id == payload.id ? e = payload : e)
        },
    },
    actions: {
        getQuestions({state, commit}, survey_id) {
            return new Promise((resolve, reject) => {
                window.axios.get(`api/v1/questions?survey_id=${survey_id}`)
                    .then(response => {
                        commit('SET_QUESTIONS', response.data)
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
        getQuestion({commit}, id) {
            return new Promise((resolve, reject) => {
                window.axios.get(`api/v1/questions/${id}`)
                    .then(response => {
                        commit('SET_QUESTION', response.data)
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
