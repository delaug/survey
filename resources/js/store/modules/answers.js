export default {
    namespaced: true,
    state: () => ({
        answer: [],
        question_id: null,
        answer_id: null
    }),
    getters: {},
    mutations: {
        SET_ANSWER(state, payload) {
            state.answer = [payload]
        },
        ADD_ANSWER(state, payload) {
            state.answer = [...state.answer.filter(e => e.field_id != payload.field_id), payload]
        },
        REMOVE_ANSWER(state, payload) {
            state.answer = state.answer.filter(e => e.field_id != payload)
        },
        CLEAR_ANSWER(state) {
            state.answer = []
        },
        SET_QUESTION_ID(state, payload) {
            state.question_id = payload
        },
        SET_ANSWER_ID(state, payload) {
            state.answer_id = payload
        },
    },
    actions: {
        answerQuestion({state, commit}, id) {
            if(!id)
                return false;

            return new Promise((resolve, reject) => {
                window.axios.post(`api/v1/surveys/${id}/answer`, {
                    'question_id': state.question_id,
                    'answer_id': state.answer_id,
                    'answers': state.answer
                })
                    .then(response => {
                        commit('surveys/UPDATE_SURVEY_QUESTION', response.data, { root: true });
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    },
}
