<template>
    <div
        id="modal-user-form"
        class="uk-flex-top"
        uk-modal
    >
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Users: {{id ? 'Edit' : 'New'}}</h2>
            </div>
            <div class="uk-modal-body">
                <Loader v-if="loading"/>

                <ui-input
                    :id="'name'"
                    :name="'name'"
                    :label="'name'"
                    :modelValue="form && form.name"
                    @input="updateData"
                />
                <ui-input
                    :id="'email'"
                    :name="'email'"
                    :label="'email'"
                    :modelValue="form && form.email"
                    @input="updateData"
                />
                <ui-input
                    :id="'password'"
                    :name="'password'"
                    :label="'password'"
                    :modelValue="form && form.password"
                    @input="updateData"
                />
                <ui-multiselect
                    :id="'roles'"
                    :name="'roles'"
                    :label="'roles'"
                    :modelValue="form && form.role_ids"
                    :options="roles"
                    @selected="selectedRoles"
                />
            </div>
            <div class="uk-modal-footer uk-text-right">
                <ui-button :class="'uk-button-default uk-modal-close'">Cancel</ui-button>
                <ui-button :class="'uk-button-primary uk-margin-small-left'" :loading="loading" @click="createOrUpdate">Save</ui-button>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from "../Loader";
    import {mapState, mapActions, mapMutations} from 'vuex';

    export default {
        name: "ModalUserForm",
        components: {Loader},
        props: {
            mode: {type: Boolean}
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapState({
                form: state => state.admin.users.form,
                roles: state => state.admin.roles.roles,
                id: state => state.admin.users.id,
                loading: state => state.admin.users.loading,
            })
        },
        methods: {
            ...mapActions({
                getRoles: 'admin/roles/getRoles',
                getUser: 'admin/users/getUser',
                postUser: 'admin/users/postUser',
                updateUser: 'admin/users/updateUser',
                deleteUser: 'admin/users/deleteUser',
            }),
            ...mapMutations({
                updateFormField: 'admin/users/UPDATE_FORM_FIELD',
            }),
            updateData(event) {
                this.updateFormField({field:event.target.id, value:event.target.value})
            },
            selectedRoles(selected) {
                this.updateFormField({field:'role_ids', value:selected})
            },
            createOrUpdate() {
                this.id
                    ? this.updateUser(this.id)
                        .then(() => this.UIkit.modal('#modal-user-form').hide())
                    : this.postUser()
                        .then(() => this.UIkit.modal('#modal-user-form').hide())
            }
        }
    }
</script>

<style scoped>
    .uk-modal-header, .uk-modal-footer {
        background: #f8f8f8;

    }
</style>
