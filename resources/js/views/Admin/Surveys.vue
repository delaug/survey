<template>
    <Loader v-if="loading"/>
    <div v-if="!loading" class="uk-margin">
        <button class="uk-button uk-button-primary" type="button" @click="onEdit(null)">New</button>
    </div>
    <ui-table
        v-if="!loading && surveys"
        :data="surveys"
        :titles="titles"
        @on-edit="onEdit"
        @on-delete="showConfirmBox"
    />
    <ModalSurveyForm />
    <ModalConfirmBox :text="'Delete survey?'" ref="confirmDeleteSurvey" @confirm="onDelete"/>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import Loader from "../../components/Loader";
    import ModalSurveyForm from "../../components/Admin/ModalSurveyForm";
    import ModalConfirmBox from "../../components/Admin/ModalConfirmBox";

    export default {
        name: "AdminSurveys",
        components: {ModalConfirmBox, ModalSurveyForm, Loader},
        data() {
            return {
                loading: false,
                titles: [
                    {field: 'id', name: 'id'},
                    {field: 'title', name: 'title'},
                    {field: 'description', name: 'description'},
                    {field: 'publish_at', name: 'publish_at'},
                    {field: 'created_at', name: 'created_at'},
                    {field: 'updated_at', name: 'updated_at'},
                    {field: 'deleted_at', name: 'deleted_at'},
                    {field: 'answers_to_questions_count', name: 'ans cnt'},
                    {field: 'user', name: 'user'},
                ]
            }
        },
        computed: {
            ...mapState({
                surveys: state => state.admin.surveys.surveys,
                user: state => state.auth.user
            })
        },
        methods: {
            ...mapActions({
                getUsers: 'admin/users/getUsers',
                getSurveys: 'admin/surveys/getSurveys',
                deleteSurvey: 'admin/surveys/deleteSurvey',
                getQuestionsBySurvey: 'admin/questions/getQuestionsBySurvey',
                getQuestionTypes: 'admin/question_types/getQuestionTypes',
            }),
            ...mapMutations({
                setID: 'admin/surveys/SET_ID',
                updateFormField: 'admin/surveys/UPDATE_FORM_FIELD',
                setQuestions: 'admin/questions/SET_QUESTIONS',
            }),
            onEdit(id) {
                this.setID(id)
                this.updateFormField({field:'user_id', value:this.user.id})
                if(id)
                    this.getQuestionsBySurvey(id)
                else
                    this.setQuestions(null);
                this.UIkit.modal('#modal-survey-form').show()
            },
            showConfirmBox(id) {
                this.$refs.confirmDeleteSurvey.show(id);
            },
            onDelete(id) {
                this.deleteSurvey(id)
            }
        },
        mounted() {
            this.loading = true

            this.getQuestionTypes()
            this.getUsers().then(() => {
                this.getSurveys().finally(() => {
                    this.loading = false
                })
            })
        }
    }
</script>

<style scoped>

</style>
