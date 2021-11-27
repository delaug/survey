<template>
    <div
        id="modal-field-form"
        class="uk-modal-container uk-flex-top"
        uk-modal
    >
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Field: {{id ? 'Edit' : 'New'}}</h2>
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
                    :id="'question_id'"
                    :name="'question_id'"
                    :label="'question_id'"
                    :value_field="'text'"
                    :modelValue="form && form.question_id"
                    :options="questions"
                    @selected="selectedQuestion"
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
        name: "ModalFieldForm",
        components: {Loader},
        props: {
            mode: {type: Boolean}
        },
        data() {
            return {}
        },
        computed: {
            ...mapState({
                form: state => state.admin.fields.form,
                id: state => state.admin.fields.id,
                loading: state => state.admin.fields.loading,
                questions: state => state.admin.questions.questions,
            }),
        },
        methods: {
            ...mapActions({
                getField: 'admin/fields/getField',
                postField: 'admin/fields/postField',
                updateField: 'admin/fields/updateField',
                deleteField: 'admin/fields/deleteField',
            }),
            ...mapMutations({
                updateFormField: 'admin/fields/UPDATE_FORM_FIELD',
            }),
            updateData(event) {
                this.updateFormField({field: event.target.id, value: event.target.value})
            },
            selectedQuestion(selected) {
                this.updateFormField({field: 'question_id', value: selected})
            },
            createOrUpdate() {
                this.id
                    ? this.updateField(this.id)
                        .then(() => this.UIkit.modal('#modal-field-form').hide())
                    : this.postField()
                        .then(() => this.UIkit.modal('#modal-field-form').hide())
            }
        }
    }
</script>

<style scoped>
    .uk-modal-header, .uk-modal-footer {
        background: #f8f8f8;

    }
</style>
