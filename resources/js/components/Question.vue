<template>
    <div v-if="question" class="uk-card uk-card-default uk-margin">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom">{{question.text}}</h3>
                    <p class="uk-text-meta">
                        <time datetime="2016-04-01T19:00">Question {{step}} /
                            {{questions.length}}
                        </time>
                    </p>
                </div>
            </div>
        </div>
        <ui-progress :class="'uk-margin-remove'" :value="step" :max="questions.length" />
        <div class="uk-card-body">
            <FieldsList
                :survey="survey"
                :type="question.type_id"
                :fields="question.fields"
                :question="question"
            />
        </div>
        <div class="uk-card-footer">
            <div class="uk-grid-small uk-child-width-auto" uk-grid>
                <div>
                    <ui-button :class="'uk-button-default'" @click="onBack" :disabled="step==1">Back</ui-button>
                </div>
                <div v-if="step != survey.questions_count">
                    <ui-button :class="'uk-button-primary'" :loading="loading" @click="onNext">Next</ui-button>
                </div>
                <div v-else>
                    <ui-button :class="'uk-button-primary'" @click="onDone">Done</ui-button>
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
                getQuestion: 'questions/getQuestion',
                getQuestions: 'questions/getQuestions',
                storeAnswers: 'answers/store',
            }),
            ...mapMutations({
                UPDATE_QUESTION: 'questions/UPDATE_QUESTION'
            }),
            checkAnswer(message) {
                if(this.question.answers.length) {
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
            sendAnswer() {
                if(this.answers.length) {
                    this.loading = true
                    this.storeAnswers().then((e) => {
                        this.UPDATE_QUESTION(e.data.question)
                        this.calculateStep()
                    }).catch(error  => {
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
                    }).finally(() => {
                        this.loading = false
                    })
                }
                else if (this.checkAnswer('Please answer the question')) {
                    this.step++
                }
            },
            onNext() {
                this.sendAnswer()
            },
            onBack() {
                this.step--
            },
            onDone() {
                this.sendAnswer()
            },
            calculateStep() {
                console.log(this.questions.find((q, ids) => {
                    if(!q.answers.length) {
                        this.step = ids + 1
                        return q
                    } else {
                        q
                        //this.step =
                    }
                }))
            }
        },
        computed: {
            ...mapState({
                questions: state => state.questions.questions,
                answers: state => state.answers.answers,
            }),
            question() {
                return this.questions ? this.questions[this.step - 1] : null
            }
        },
        mounted() {
            this.getQuestions(this.survey.id).then(() => {
                this.calculateStep()
            })
        }
    }
</script>

<style scoped>

</style>
