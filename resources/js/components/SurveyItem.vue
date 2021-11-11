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
                <li><a href="#"><span>Questions:</span> {{survey.answers_to_questions_count}} / {{survey.questions_count}}</a></li>
            </ul>
        </div>
        <div class="uk-card-body">
            <p>{{survey.description}}</p>
        </div>
        <div class="uk-card-footer" v-if="user">
            <ui-button
                :class="!status ? 'uk-button-primary' : 'uk-button-default'"
                :loading="loading"
                @click="onTakeSurvey"
                :disabled="status"
            >
                <span :uk-icon="'icon: ' + getButtonIcon()"></span>
                {{getButtonText()}}
            </ui-button>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
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
            ...mapGetters({
                isDone: 'surveys/isDone'
            }),
            status() {
                return this.isDone(this.survey.id);
            }
        },
        methods: {
            onTakeSurvey() {
                router.push({ name: 'SurveyDetail', params: { id: this.survey.id } })
            },
            getButtonText() {
                if(!this.isDone(this.survey.id))
                    return !this.survey.answers_to_questions_count ? 'Start' : 'Continue'
                else
                    return 'Done'
            },
            getButtonIcon() {
                if(!this.isDone(this.survey.id))
                    return !this.survey.answers_to_questions_count ? 'play' : 'future'
                else
                    return 'check'
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
