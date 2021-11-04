<template>
    <nav class="uk-navbar-container uk-margin">
        <div class="uk-container">
            <div class="uk-navbar">
                <div v-if="leftMenu && leftMenu.length"
                     class="uk-navbar-left"
                >
                    <router-link :to="'/'" class="uk-navbar-item uk-logo">
                        <img src="/favicon.ico">
                    </router-link>

                    <MainMenu :items="leftMenu"/>
                </div>
                <div
                    v-if="rightMenu && rightMenu.length"
                    class="uk-navbar-right">

                    <MainMenu v-if="!user" :items="rightMenu"/>

                    <ul v-else class="uk-navbar-nav">
                        <li>
                            <a class="uk-navbar-toggle" uk-navbar-toggle-icon href="#"></a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li class="uk-active">Signed in as: <b>{{user.name}}</b></li>
                                    <li class="uk-nav-divider"></li>
                                    <li><a @click="onLogout"><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
</template>

<script>
    import MainMenu from "./MainMenu";
    import {mapState, mapActions} from 'vuex';

    export default {
        name: 'NavBar',
        components: {MainMenu},
        data() {
            return {}
        },
        computed: {
            ...mapState({
                user: state => state.auth.user
            }),
            leftMenu() {
                return this.$router.options.routes.filter(e => e.position == 'left')
            },
            rightMenu() {
                return this.$router.options.routes.filter(e => e.position == 'right')
            }
        },
        methods: {
            ...mapActions({
                logout: 'auth/logout'
            }),
            onLogout() {
                this.logout()
            }
        },
        mounted() {
            this.UIkit.navbar('.uk-navbar-right', {});
        }
    }
</script>
