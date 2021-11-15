<template>
    <div class="uk-position-center">
        <div class="uk-width-expand@m uk-first-column uk-text-center">
            <h1 class="uk-article-title">
                <span class="uk-link-reset">Access denied!</span>
            </h1>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        name: "AccessDenied",
        computed:{
            ...mapGetters({
                isAdmin: 'auth/isAdmin'
            })
        },
        mounted() {
            if(this.isAdmin) {
                this.$router.push('dashboard')
            }
        }
    }
</script>

<style scoped>

</style>
