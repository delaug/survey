<template>
    <Loader v-if="loading"/>
    <div v-if="!loading && user" class="uk-margin">
        <button class="uk-button uk-button-primary" type="button" @click="onEdit(null)">New</button>
    </div>
    <ui-table
        v-if="!loading && users"
        :data="users"
        :titles="titles"
        @on-edit="onEdit"
        @on-delete="showConfirmBox"
    />
    <ModalUserForm />
    <ModalConfirmBox :text="'Delete user?'" ref="confirmDeleteUser" @confirm="onDelete"/>
</template>

<script>
import {mapState, mapActions, mapMutations} from 'vuex';
import Loader from "../../components/Loader";
import ModalUserForm from "../../components/Admin/ModalUserForm";
import ModalConfirmBox from "../../components/Admin/ModalConfirmBox";
    export default {
        name: "Users",
        components: {ModalConfirmBox, ModalUserForm, Loader},
        data() {
            return {
                loading: false,
                titles: [
                    {field: 'id', name: 'id'},
                    {field: 'name', name: 'name'},
                    {field: 'email', name: 'email'},
                    {field: 'email_verified_at', name: 'verified_at'},
                    {field: 'created_at', name: 'created_at'},
                    {field: 'updated_at', name: 'updated_at'},
                    {field: 'roles', name: 'roles'},
                ]
            }
        },
        computed: {
            ...mapState({
                users: state => state.admin.users.users,
                user: state => state.auth.user,
            })
        },
        methods: {
            ...mapActions({
                getUsers: 'admin/users/getUsers',
                deleteUser: 'admin/users/deleteUser'
            }),
            ...mapMutations({
                setID: 'admin/users/SET_ID'
            }),
            onEdit(id) {
                this.setID(id)
                this.UIkit.modal('#modal-user-form').show()
            },
            showConfirmBox(id) {
                this.$refs.confirmDeleteUser.show(id);
            },
            onDelete(id) {
                this.deleteUser(id)
            }
        },
        mounted() {
            this.loading = true
            this.getUsers().finally(() => {
                this.loading = false
            })
        }
    }
</script>

<style scoped>

</style>
