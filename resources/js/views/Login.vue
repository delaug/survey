<template>
    <div class="uk-padding uk-padding-remove-horizontal">
        <div class="uk-flex uk-flex-center uk-flex-middle">
            <div class="uk-card uk-card-default uk-card-hover uk-card-body uk-width-large">
                <router-link
                    class="uk-flex uk-flex-center"
                    :to="'/'"
                >
                    <img src="/favicon.ico" alt=""/>
                </router-link>
                <p class="uk-card-title uk-flex uk-flex-center"> Sign In</p>
                <form class="uk-form-stacked">
                    <div class="uk-margin">
                        <ui-input
                            :type="'email'"
                            :id="'email'"
                            :name="'email'"
                            :placeholder="'Email address'"
                            :label="'Email address'"
                            v-model="login"
                        />
                    </div>
                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <ui-input
                                :type="'password'"
                                :id="'password'"
                                :name="'password'"
                                :placeholder="'Password'"
                                :label="'Password'"
                                v-model="password"
                            />
                        </div>
                    </div>
                    <div class="uk-margin">
                        <ui-button
                            :class="'uk-button-primary uk-width-1-1'"
                        >
                            Sign In
                        </ui-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                login: '',
                password: '',
            }
        },
    }
</script>

<style scoped>

</style>
