<template>
    <Loader v-if="loading"/>
    <div v-if="!loading && user" class="uk-margin">
        <button class="uk-button uk-button-primary" type="button" @click="onEdit(null)">New</button>
    </div>
    <ui-table
        v-if="!loading && surveys"
        :data="surveys"
        :titles="titles"
        @on-edit="onEdit"
        @on-delete="showConfirmBox"
    />
    <Observer @intersect="intersected"/>
    <Loader v-if="loadingPage"/>
    <ModalSurveyForm />
    <ModalConfirmBox :text="'Delete survey?'" ref="confirmDeleteSurvey" @confirm="onDelete"/>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import Loader from "../../components/Loader";
    import ModalSurveyForm from "../../components/Admin/ModalSurveyForm";
    import ModalConfirmBox from "../../components/Admin/ModalConfirmBox";
    import Observer from "../../components/Observer";

    export default {
        name: "AdminSurveys",
        components: {Observer, ModalConfirmBox, ModalSurveyForm, Loader},
        data() {
            return {
                loading: false,
                loadingPage: false,
                titles: [
                    {field: 'id', name: 'id'},
                    {field: 'img', name: 'img', type: 'img'},
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
            }),
            ...mapMutations({
                setID: 'admin/surveys/SET_ID',
                updateFormField: 'admin/surveys/UPDATE_FORM_FIELD',
            }),
            onEdit(id) {
                this.setID(id)
                this.updateFormField({field:'user_id', value:this.user.id})
                this.UIkit.modal('#modal-survey-form').show()
            },
            showConfirmBox(id) {
                this.$refs.confirmDeleteSurvey.show(id);
            },
            onDelete(id) {
                this.deleteSurvey(id)
            },
            intersected() {
                this.loadingPage = true;
                this.getSurveys().finally(() => {
                    this.loadingPage = false
                })
            }
        },
        mounted() {
            this.loading = true
            this.getUsers().then(() => {
                this.loading = false
            })
        }
    }
</script>

<style scoped>

</style>
