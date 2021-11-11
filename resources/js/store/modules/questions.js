export default {
    namespaced: true,
    state: () => ({
        question: null,
        current_page: 1,
        last_page: null,
        next_page: null
    }),
    getters: {},
    mutations: {
        SET_DATA(state, payload) {
            state.question = payload.data[0]
            state.current_page = payload.current_page
            state.last_page = payload.last_page
        },
        NEXT(state) {
            state.next_page = state.current_page < state.last_page ? state.current_page+1 : state.current_page
        },
        BACK(state) {
            state.next_page = state.current_page > 1 ? state.current_page-1 : state.current_page
        }
    },
    actions: {
        getQuestion({state, commit}, survey_id) {
            return new Promise((resolve, reject) => {
                window.axios.get(`api/v1/questions?question=${state.next_page}&survey_id=${survey_id}`)
                    .then(response => {
                        commit('SET_DATA', response.data)
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
        getNext({commit, dispatch}, survey_id) {
            commit('NEXT')
            return dispatch('getQuestion', survey_id)
        },
        getBack({commit, dispatch}, survey_id) {
            commit('BACK')
            return dispatch('getQuestion', survey_id)
        }
    },
}
