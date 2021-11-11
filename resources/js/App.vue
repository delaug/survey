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
