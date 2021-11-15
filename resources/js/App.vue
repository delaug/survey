<template>
    <NavBar/>
    <div class="uk-container">
        <AdminPanel v-if="isAdmin"/>
        <router-view/>
    </div>
</template>

<script>

    import {mapState, mapGetters, mapMutations} from 'vuex';
    import NavBar from "./components/User/NavBar";
    import AdminPanel from "./components/Admin/AdminPanel";

    export default {
        name: 'App',
        components: {AdminPanel, NavBar},
        computed: {
            ...mapState({
                token: state => state.auth.token,
                user: state => state.auth.user,
            }),
            ...mapGetters({
                isAdmin: 'auth/isAdmin'
            })
        },
        methods: {
            ...mapMutations({
                SET_DATA:'auth/SET_DATA',
            })
        },
        mounted() {
            this.SET_DATA({
                token: localStorage.getItem('token') ? localStorage.getItem('token') : null,
                user: localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null
            })
        }
    }
</script>

<style scoped>
</style>
