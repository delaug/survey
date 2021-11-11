export default {
    namespaced: true,
    state: () => ({
        answers: [],
    }),
    getters: {},
    mutations: {
        SET_ANSWER(state, payload) {
            state.answers = [payload]
        },
        ADD_ANSWER(state, payload) {
            state.answers = [...state.answers.filter(e => e.field_id != payload.field_id), payload]
        },
        REMOVE_ANSWER(state, payload) {
            state.answers = state.answers.filter(e => e.field_id != payload)
        },
        CLEAR_ANSWER(state) {
            state.answers = []
        }
    },
    actions: {
        store({state, commit}) {
            return new Promise((resolve, reject) => {
                window.axios.post(`api/v1/answers`, state.answers)
                    .then(response => {
                        commit('CLEAR_ANSWER')

                        if(response.data.answers_to_questions_count)
                            commit('surveys/SET_ANSWERS_TO_QUESTIONS_COUNT', response.data.answers_to_questions_count, {root: true})

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
