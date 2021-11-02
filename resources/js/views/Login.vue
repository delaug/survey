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
                <ui-alert
                    v-if="error"
                    :class="'uk-alert-danger'"
                >
                    {{error}}
                </ui-alert>
                <form class="uk-form-stacked">
                    <div class="uk-margin">
                        <ui-input
                            :type="'email'"
                            :id="'email'"
                            :name="'email'"
                            :placeholder="'Email address'"
                            :label="'Email address'"
                            v-model="email"
                            :error="errors.email"
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
                                :error="errors.password"
                            />
                        </div>
                    </div>
                    <div class="uk-margin">
                        <ui-button
                            :class="'uk-button-primary uk-width-1-1'"
                            :loading="loading"
                            @click="handleSubmit"
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
    import {mapActions} from 'vuex';
    import router from "../router";

    export default {
        data() {
            return {
                email: 'delaug@bk.ru',
                password: 'password',
                errors: [],
                error: null,
                loading: false
            }
        },
        methods: {
            ...mapActions({
                login: 'auth/login'
            }),

            validateValues() {
                if (!this.email) {
                    this.errors.email = 'Email is required'
                } else if (!/\S+@\S+\.\S+/.test(this.email)) {
                    this.errors.email = 'Email address is invalid'
                }

                if (!this.password) {
                    this.errors.password = 'Password is required'
                } else if (this.password.length < 6) {
                    this.errors.password = 'Password must be more than 6 characters'
                }
            },
            setErrors(data) {
                if (data.error)
                    this.error = data.error
                if (data.errors.email)
                    this.errors.email = data.errors.email.join()
                if (data.errors.password)
                    this.errors.password = data.errors.password.join()
            },
            handleSubmit(event) {
                this.errors = []
                this.error = null

                this.validateValues()

                if (Object.keys(this.errors).length === 0) {
                    this.loading = true;
                    this.login({'email': this.email, 'password': this.password, 'device_name': navigator.userAgent})
                        .then(response => {
                            this.email = null
                            this.password = null

                            this.UIkit.notification({
                                message: `Welcome, ${response.data.user.name}`,
                                status: 'success',
                                pos: 'top-right',
                                timeout: 2000
                            });
                            router.go(-1)
                        })
                        .catch(error => {
                            if (this.errors != undefined)
                                this.setErrors(error.response.data)
                            else
                                this.UIkit.notification({
                                    message: error.response.data.error,
                                    status: 'danger',
                                    pos: 'top-right',
                                    timeout: 2000
                                });
                        })
                        .finally(() => {
                            this.loading = false;
                        })
                }
            }
        }
    }
</script>


<style scoped>

</style>
