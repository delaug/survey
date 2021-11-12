<template>
    <div v-if="question" class="uk-card uk-card-default uk-margin">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom">{{question.text}}</h3>
                    <p class="uk-text-meta">
                        <time datetime="2016-04-01T19:00">Question {{current_page}} /
                            {{last_page}}
                        </time>
                    </p>
                </div>
            </div>
        </div>
        <ui-progress :class="'uk-margin-remove'" :value="current_page" :max="last_page" />
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
                    <ui-button :class="'uk-button-default'" @click="onBack" :disabled="current_page==1">Back</ui-button>
                </div>
                <div>
                    <ui-button :class="'uk-button-primary'" :loading="loading" @click="onNext">{{current_page != last_page ? 'Next' : 'Done'}}</ui-button>
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
                loading: false
            }
        },
        methods: {
            ...mapActions({
                getQuestion: 'questions/getQuestion',
                getNext: 'questions/getNext',
                getBack: 'questions/getBack',
                storeAnswers: 'answers/store',
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
                    this.storeAnswers().then((response) => {
                        this.getNext(this.survey.id)
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
                    this.getNext(this.survey.id)
                }
            },
            onNext() {
                this.sendAnswer()
            },
            onBack() {
                this.getBack(this.survey.id)
            }
        },
        computed: {
            ...mapState({
                question: state => state.questions.question,
                current_page: state => state.questions.current_page,
                last_page: state => state.questions.last_page,
                answers: state => state.answers.answers,
            })
        },
        mounted() {
            this.getQuestion(this.survey.id)
        }
    }
</script>

<style scoped>

</style>
