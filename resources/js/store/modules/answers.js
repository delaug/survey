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
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    },
}
