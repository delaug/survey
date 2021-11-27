<template>
    <Loader v-if="loading"/>
    <div v-if="!loading" class="uk-margin">
        <button class="uk-button uk-button-primary" type="button" @click="onEdit(null)">New</button>
    </div>
    <ui-table
        v-if="!loading && questions"
        :data="questions"
        :titles="titles"
        @on-edit="onEdit"
        @on-delete="showConfirmBox"
    />
    <ModalQuestionForm/>
    <ModalConfirmBox :text="'Delete question?'" ref="confirmDeleteQuestion" @confirm="onDelete"/>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import Loader from "../../components/Loader";
    import ModalConfirmBox from "../../components/Admin/ModalConfirmBox";
    import ModalQuestionForm from "../../components/Admin/ModalQuestionForm";

    export default {
        name: "AdminQuestions",
        components: {ModalQuestionForm, ModalConfirmBox, Loader},
        data() {
            return {
                loading: false,
                titles: [
                    {field: 'id', name: 'id'},
                    {field: 'text', name: 'text'},
                    {field: 'sort', name: 'sort'},
                    {field: 'type', name: 'type'},
                    {field: 'survey_id', name: 'survey_id'},
                    {field: 'created_at', name: 'created_at'},
                    {field: 'updated_at', name: 'updated_at'},
                    {field: 'deleted_at', name: 'deleted_at'},
                ]
            }
        },
        computed: {
            ...mapState({
                questions: state => state.admin.questions.questions,
            })
        },
        methods: {
            ...mapActions({
                getSurveys: 'admin/surveys/getSurveys',
                getQuestions: 'admin/questions/getQuestions',
                deleteQuestion: 'admin/questions/deleteQuestion',
                getQuestionTypes: 'admin/question_types/getQuestionTypes',
            }),
            ...mapMutations({
                setID: 'admin/questions/SET_ID',
                updateFormField: 'admin/questions/UPDATE_FORM_FIELD',
            }),
            onEdit(id) {
                this.setID(id)
                this.UIkit.modal('#modal-question-form').show()
            },
            showConfirmBox(id) {
                this.$refs.confirmDeleteQuestion.show(id);
            },
            onDelete(id) {
                this.deleteQuestion(id)
            }
        },
        mounted() {
            this.loading = true
            this.getQuestionTypes()
            this.getSurveys()
            this.getQuestions().finally(() => {
                this.loading = false
            })
        }
    }
</script>

<style scoped>

</style>
