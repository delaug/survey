<template>
    <div
        id="modal-survey-form"
        class="uk-modal-container uk-flex-top"
        uk-modal
    >
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Survey: {{id ? 'Edit' : 'New'}}</h2>
            </div>
            <div class="uk-modal-body">
                <Loader v-if="loading"/>

                <ui-input
                    :id="'title'"
                    :name="'title'"
                    :label="'title'"
                    :modelValue="form && form.title"
                    @input="updateData"
                />
                <ui-textarea
                    :id="'description'"
                    :name="'description'"
                    :label="'description'"
                    :rows="4"
                    :modelValue="form && form.description"
                    @input="updateData"
                />
                <ui-select
                    :id="'user_id'"
                    :name="'user_id'"
                    :label="'user_id'"
                    :modelValue="form && form.user_id"
                    :options="users"
                    @selected="selectedUser"
                />
                <ui-checkbox
                    :id="'is_publish'"
                    :name="'is_publish'"
                    :type="'checkbox'"
                    :modelValue="form && form.is_publish"
                    @change="changePublish"
                >
                    is_publish
                </ui-checkbox>

                <QuestionTabs/>
                <Question :question="currentQuestion" :index="item_index"/>
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
    import Question from "./Question";
    import QuestionTabs from "./QuestionTabs";

    export default {
        name: "ModalSurveyForm",
        components: {QuestionTabs, Question, Loader},
        props: {
            mode: {type: Boolean}
        },
        data() {
            return {}
        },
        computed: {
            ...mapState({
                users: state => state.admin.users.users,
                form: state => state.admin.surveys.form,
                id: state => state.admin.surveys.id,
                loading: state => state.admin.surveys.loading,
                item_index: state => state.admin.questions.item_index,
            }),
            ...mapGetters({
                currentQuestion: 'admin/questions/currentQuestion'
            })
        },
        methods: {
            ...mapActions({
                getSurvey: 'admin/surveys/getSurvey',
                postSurvey: 'admin/surveys/postSurvey',
                updateSurvey: 'admin/surveys/updateSurvey',
                deleteSurvey: 'admin/surveys/deleteSurvey',
            }),
            ...mapMutations({
                updateFormField: 'admin/surveys/UPDATE_FORM_FIELD',
            }),
            updateData(event) {
                this.updateFormField({field: event.target.id, value: event.target.value})
            },
            selectedUser(selected) {
                this.updateFormField({field: 'user_id', value: selected})
            },
            changePublish(event) {
                this.updateFormField({field: event.target.id, value: event.target.checked})
            },
            createOrUpdate() {
                this.id
                    ? this.updateSurvey(this.id)
                        .then(() => this.UIkit.modal('#modal-survey-form').hide())
                    : this.postSurvey()
                        .then(() => this.UIkit.modal('#modal-survey-form').hide())
            }
        }
    }
</script>

<style scoped>
    .uk-modal-header, .uk-modal-footer {
        background: #f8f8f8;

    }
</style>
