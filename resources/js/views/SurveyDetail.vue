<template>
    <Loader v-if="loading"/>

    <article v-else-if="survey" class="uk-article">
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
                id: null
            }
        },
        computed: {
            ...mapState({
                survey: state => state.survey.survey,
                loading: state => state.survey.loading
            }),
        },
        methods: {
            ...mapActions({
                getSurvey: 'survey/getSurvey',
                getLoading: 'survey/getLoading'
            })
        },
        mounted() {
            this.id = this.$route.params.id
            this.getSurvey(this.id);
        }

    }
</script>

<style scoped>

</style>
