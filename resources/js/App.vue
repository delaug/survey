<template>
    <NavBar/>
    <div class="uk-container">
        <router-view/>
    </div>
</template>

<script>
    import NavBar from "./components/NavBar";
    import {mapState, mapMutations} from 'vuex';

    export default {
        name: 'App',
        components: {
            NavBar
        },
        computed: {
            ...mapState({
                token: state => state.auth.token,
                user: state => state.auth.user,
            })
        },
        methods: {
            ...mapMutations({
                SET_TOKEN:'auth/SET_TOKEN',
                SET_USER:'auth/SET_USER',
            })
        },
        mounted() {
            this.SET_TOKEN(localStorage.getItem('token') ? localStorage.getItem('token') : null);
            this.SET_USER(localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null);
        }
    }
</script>

<style scoped>
</style>
