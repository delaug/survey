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

                    <MainMenu :items="leftMenu" />
                </div>
                <div
                    v-if="rightMenu && rightMenu.length"
                    class="uk-navbar-right">

                    <MainMenu :items="rightMenu" />
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    import MainMenu from "./MainMenu";

    export default {
        name: 'NavBar',
        components: {MainMenu},
        data() {
            return {}
        },
        computed: {
            leftMenu() {
                return this.$router.options.routes.filter(e => e.position == 'left')
            },
            rightMenu() {
                return this.$router.options.routes.filter(e => e.position == 'right')
            }
        }
    }
</script>
