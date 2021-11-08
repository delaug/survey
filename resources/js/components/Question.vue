<template>
    <div v-if="question" class="uk-card uk-card-default uk-margin">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom">{{question.text}}</h3>
                    <p class="uk-text-meta">
                        <time datetime="2016-04-01T19:00">Question {{step}} /
                            {{questions_count}}
                        </time>
                    </p>
                </div>
            </div>
        </div>
        <ui-progress :class="'uk-margin-remove'" :value="step" :max="questions_count" />
        <div class="uk-card-body">
            <FieldsList
                :type="question.type.id"
                :fields="question.fields"
                :question="question"
            />
        </div>
        <div class="uk-card-footer">
            <div class="uk-grid-small uk-child-width-auto" uk-grid>
                <div>
                    <ui-button :class="'uk-button-default'" @click="back" :disabled="step==1">Back</ui-button>
                </div>
                <div v-if="step != questions_count">
                    <ui-button :class="'uk-button-primary'" :loading="loading" @click="next">Next</ui-button>
                </div>
                <div v-else>
                    <ui-button :class="'uk-button-primary'" @click="done">Done</ui-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import FieldsList from "./FieldsList";
    export default {
        name: "Question",
        components: {FieldsList},
        props: {
            survey: {
                type: Object,
                required: true
            },
            questions: {
                type: Array,
                required: true
            },
            questions_count: {
                type: Number,
                required: true
            }
        },
        data() {
            return {
                step: 1,
                loading: false
            }
        },
        methods: {
            ...mapActions({
                answerQuestion: 'answers/answerQuestion',
                readAnswers: 'answers/readAnswers',
            }),
            ...mapMutations({
                clearAnswer: 'answers/CLEAR_ANSWER',
                setQuestionId: 'answers/SET_QUESTION_ID',
                setAnswerId: 'answers/SET_ANSWER_ID',
            }),
            checkAnswer(message) {
                if(this.answer.length) {
                    return true
                } else {
                    this.UIkit.notification({
                        message: message,
                        status: 'danger',
                        pos: 'top-right',
                        timeout: 2000
                    });
                    return false
                }
            },
            next() {
                if(this.checkAnswer('Answer question')) {
                    this.loading = true

                    this.answerQuestion(this.survey.id)
                        .then(() => {
                            this.clearAnswer()
                            this.step++;
                        })
                        .catch(error  => {
                            for(var key in error.response.data.errors) {
                                error.response.data.errors[key].map(error => {
                                    this.UIkit.notification({
                                        message: `<b>"${key}"</b>: ${error}`,
                                        status: 'danger',
                                        pos: 'top-right',
                                        timeout: 2000
                                    });
                                })
                            }
                        })
                        .finally(() => {
                            this.loading = false
                        })
                }
            },
            back() {
                this.readAnswers()
                this.clearAnswer()
                this.step--;
            },
            done() {
                if(this.checkAnswer('Answer question for done')) {

                }
            },
        },
        watch: {
            question: function(val) {
                this.setQuestionId(val.id)
            },
        },
        computed: {
            ...mapState({
                answer: state => state.answers.answer
            }),
            question() {
                return this.questions[this.step - 1]
            }
        },
        mounted() {
            this.clearAnswer()
            this.setQuestionId(this.question.id)
            this.setAnswerId(this.survey.answer ? this.survey.answer.id : null)
        }
    }
</script>

<style scoped>

</style>
