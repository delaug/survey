<template>
    <div
        id="modal-question-form"
        class="uk-modal-container uk-flex-top"
        uk-modal
    >
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Question: {{id ? 'Edit' : 'New'}}</h2>
            </div>
            <div class="uk-modal-body">
                <Loader v-if="loading"/>

                <ui-input
                    :id="'text'"
                    :name="'text'"
                    :label="'text'"
                    :modelValue="form && form.text"
                    @input="updateData"
                />
                <ui-input
                    :id="'sort'"
                    :name="'sort'"
                    :label="'sort'"
                    :modelValue="form && form.sort"
                    @input="updateData"
                />
                <ui-select
                    :id="'type_id'"
                    :name="'type_id'"
                    :label="'type_id'"
                    :modelValue="form && form.type_id"
                    :options="question_types"
                    @selected="selectedQuestionType"
                />
                <ui-select
                    :id="'survey_id'"
                    :name="'survey_id'"
                    :label="'survey_id'"
                    :value_field="'title'"
                    :modelValue="form && form.survey_id"
                    :options="surveys"
                    @selected="selectedSurvey"
                />
            </div>
            <div class="uk-modal-footer uk-text-right">
                <ui-button :class="'uk-button-default uk-modal-close'">Cancel</ui-button>
                <ui-button :class="'uk-button-primary uk-margin-small-left'" :loading="loading" @click="createOrUpdate">
                    Save
                </ui-button>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from "../Loader";
    import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

    export default {
        name: "ModalQuestionForm",
        components: {Loader},
        props: {
            mode: {type: Boolean}
        },
        data() {
            return {}
        },
        computed: {
            ...mapState({
                form: state => state.admin.questions.form,
                id: state => state.admin.questions.id,
                loading: state => state.admin.questions.loading,
                question_types: state => state.admin.question_types.question_types,
                surveys: state => state.admin.surveys.surveys,
            }),
        },
        methods: {
            ...mapActions({
                getQuestion: 'admin/questions/getQuestion',
                postQuestion: 'admin/questions/postQuestion',
                updateQuestion: 'admin/questions/updateQuestion',
                deleteQuestion: 'admin/questions/deleteQuestion',
            }),
            ...mapMutations({
                updateFormField: 'admin/questions/UPDATE_FORM_FIELD',
            }),
            updateData(event) {
                this.updateFormField({field: event.target.id, value: event.target.value})
            },
            selectedQuestionType(selected) {
                this.updateFormField({field: 'type_id', value: selected})
            },
            selectedSurvey(selected) {
                this.updateFormField({field: 'survey_id', value: selected})
            },
            createOrUpdate() {
                this.id
                    ? this.updateQuestion(this.id)
                        .then(() => this.UIkit.modal('#modal-question-form').hide())
                    : this.postQuestion()
                        .then(() => this.UIkit.modal('#modal-question-form').hide())
            }
        }
    }
</script>

<style scoped>
    .uk-modal-header, .uk-modal-footer {
        background: #f8f8f8;

    }
</style>
