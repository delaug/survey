<template>
    <div class="uk-card uk-card-default uk-margin">
        <div class="uk-card-header">
            <h3 class="uk-card-title">{{survey.title}}</h3>
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
            <router-link :to="{name:'SurveyDetail', params: {id: survey.id}}" class="uk-button uk-button-primary">Take survey</router-link>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        name: "SurveyItem",
        props: {
            survey: {
                type: Object,
                required: true
            }
        },
        computed: {
            ...mapState({
                user: state => state.auth.user
            })
        }
    }
</script>

<style scoped>
    .uk-card-header,.uk-card-body, .uk-card-footer {
        border-top: none;
        border-bottom: none;
    }
</style>
