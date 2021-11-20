<template>
    <Loader v-if="loading"/>

    <div v-if="!user" class="uk-grid">
        <div class="uk-align-center">
            Please auth for take survey.
        </div>
    </div>

    <article v-else-if="user && survey" class="uk-article">
        <h1 class="uk-article-title">
            <span class="uk-margin-small-right uk-icon" uk-icon="icon:question; ratio: 2"></span>
            {{survey.title}}
        </h1>

        <Question
            v-if="!surveyIsDone"
            :survey="survey"
        />
        <div v-else class="uk-grid">
            <div class="uk-align-center">
                Thank you for your answers.
            </div>
        </div>

    </article>

    <div v-else>
        <div class="uk-card uk-card-default uk-card-body uk-text-center">
            <h3 class="uk-card-title">404. Survey not found or no started!</h3>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapMutations, mapActions} from 'vuex';
    import Loader from "../components/Loader";
    import Question from "../components/User/Question";

    export default {
        name: "SurveyDetail",
        components: {Question, Loader},
        data() {
            return {
                id: null,
                loading: false
            }
        },
        computed: {
            ...mapState({
                user: state => state.auth.user,
                survey: state => state.surveys.survey,
            }),
            ...mapGetters({
                surveyIsDone: 'surveys/surveyIsDone',
            }),
        },
        methods: {
            ...mapActions({
                getSurvey: 'surveys/getSurvey',
            }),
            ...mapMutations({
                setSurvey: 'surveys/SET_SURVEY',
                clearQuestionData: 'questions/CLEAR_DATA',
            })
        },
        mounted() {
            if(this.user) {
                this.loading = true
                this.id = this.$route.params.id
                this.getSurvey(this.id).finally(() => {
                    this.loading = false
                });
            }
        },
        unmounted() {
            this.clearQuestionData()
            this.setSurvey(null)
        }

    }
</script>

<style scoped>

</style>
