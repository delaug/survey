<template>
    <div class="uk-card uk-card-default uk-margin">
        <div class="uk-card-header">
            <h3 class="uk-card-title">{{survey.title}}</h3>
            <p class="uk-text-meta uk-margin-remove-top"><time>{{survey.created_at}}</time></p>
        </div>
        <div class="uk-card-body">
            <p>{{survey.description}}</p>
        </div>
        <div class="uk-card-footer">
            <router-link :to="{name:'SurveyDetail', params: {id: survey.id}}" class="uk-button uk-button-text">Read more</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SurveyItem",
        props: {
            survey: {
                type: Object,
                required: true
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
