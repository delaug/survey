<template>
    <div class="uk-card uk-card-small uk-card-default uk-margin">
        <div class="uk-card-header">
            <h3 class="uk-card-title">
                <span class="uk-margin-small-right uk-icon" uk-icon="icon:question; ratio: 2"></span>
                #{{survey.id}}
                {{survey.title}}
            </h3>
            <p class="uk-article-meta">Created by <a href="#"><b>{{survey.user.name}}</b></a> on {{survey.created_at}}.</p>
            <hr class="uk-divider-small">
            <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                <li><a href="#">{{survey.created_at}}</a></li>
                <li><a href="#"><span>Questions:</span> {{survey.questions_count}}</a></li>
            </ul>
        </div>
        <div class="uk-card-body">
            <p>{{survey.description}}</p>
        </div>
        <div class="uk-card-footer" v-if="user">
            <ui-button
                :class="status ? 'uk-button-primary' : 'uk-button-default'"
                :loading="loading"
                @click="onTakeSurvey"
            >
                {{status ? 'Start' : 'Continue'}}
            </ui-button>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import router from "../router";
    export default {
        name: "SurveyItem",
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
        computed: {
            ...mapState({
                user: state => state.auth.user
            }),
            status() {
                return !this.survey.answer ? true : false;
            }
        },
        methods: {
            onTakeSurvey() {
                router.push({ name: 'SurveyDetail', params: { id: this.survey.id } })
            }
        }
    }
</script>

<style scoped>
    .uk-card-header,.uk-card-body, .uk-card-footer {
        border-top: none;
        border-bottom: none;
    }
</style>
