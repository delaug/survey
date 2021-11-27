<template>
    <Loader v-if="loading"/>
    <div v-if="!loading && user" class="uk-margin">
        <button class="uk-button uk-button-primary" type="button" @click="onEdit(null)">New</button>
    </div>
    <ui-table
        v-if="!loading && fields"
        :data="fields"
        :titles="titles"
        @on-edit="onEdit"
        @on-delete="showConfirmBox"
    />
    <Observer @intersect="intersected"/>
    <Loader v-if="loadingPage"/>
    <ModalFieldForm/>
    <ModalConfirmBox :text="'Delete field?'" ref="confirmDeleteField" @confirm="onDelete"/>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import Loader from "../../components/Loader";
    import ModalConfirmBox from "../../components/Admin/ModalConfirmBox";
    import ModalFieldForm from "../../components/Admin/ModalFieldForm";
    import Observer from "../../components/Observer";


    export default {
        name: "AdminFields",
        components: {Observer, ModalFieldForm, ModalConfirmBox, Loader},
        data() {
            return {
                loading: false,
                loadingPage: false,
                titles: [
                    {field: 'id', name: 'id'},
                    {field: 'text', name: 'text'},
                    {field: 'sort', name: 'sort'},
                    {field: 'question_id', name: 'question_id'},
                    {field: 'created_at', name: 'created_at'},
                    {field: 'updated_at', name: 'updated_at'},
                    {field: 'deleted_at', name: 'deleted_at'},
                ]
            }
        },
        computed: {
            ...mapState({
                fields: state => state.admin.fields.fields,
                user: state => state.auth.user,
            })
        },
        methods: {
            ...mapActions({
                getQuestions: 'admin/questions/getQuestions',
                getFields: 'admin/fields/getFields',
                deleteField: 'admin/fields/deleteField',
            }),
            ...mapMutations({
                setID: 'admin/fields/SET_ID',
                updateFormField: 'admin/fields/UPDATE_FORM_FIELD',
            }),
            onEdit(id) {
                this.setID(id)
                this.UIkit.modal('#modal-field-form').show()
            },
            showConfirmBox(id) {
                this.$refs.confirmDeleteField.show(id);
            },
            onDelete(id) {
                this.deleteField(id)
            },
            intersected() {
                this.loadingPage = true;
                this.getFields().finally(() => {
                    this.loadingPage = false
                })
            }
        },
        mounted() {
            this.loading = true
            this.getQuestions().then(
                () => this.loading = false
            )
        }
    }
</script>

<style scoped>

</style>
