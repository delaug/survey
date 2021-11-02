<template>
    <Loader v-if="loading"/>

    <div v-if="!user" class="uk-grid">
        <div class="uk-align-center">
            Please auth for take survey.
        </div>
    </div>

    <article v-else-if="user && survey" class="uk-article">
        <h1 class="uk-article-title"><a class="uk-link-reset" href="">{{survey.title}}</a></h1>
        <p class="uk-article-meta">Written by <a href="#">Admin</a> on {{survey.created_at}}. Posted in <a href="#">Blog</a></p>
        <p class="uk-text-lead">{{survey.description}}</p>

        <Question
            :questions="survey.questions"
            :questions_count="survey.questions_count"
        />
    </article>

    <div v-else>
        404 Not found
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import Loader from "../components/Loader";
    import Question from "../components/Question";

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
        },
        methods: {
            ...mapActions({
                getSurvey: 'surveys/getSurvey',
            })
        },
        mounted() {
            if(this.user) {
                this.loading = true
                this.id = this.$route.params.id
                this.getSurvey(this.id).then(() => {
                    this.loading = false
                });
            }
        }

    }
</script>

<style scoped>

</style>
