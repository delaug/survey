<template>
    <button v-if="!loading" :class="buttonClass" :type="type" :disabled="disabled">
        <slot></slot>
    </button>
    <button v-else :class="buttonClass" :type="type" disabled>
        <span class="spinner-grow spinner-grow-sm" role="status"
              aria-hidden="true"></span>
        &nbsp;Loading...
    </button>
</template>

<script>
    export default {
        name: 'ui-button',
        props: {
            type: {
                type: String,
                default: 'button'
            },
            class: {
                type: String,
                default: null
            },
            loading: {
                type: Boolean,
                default: false
            },
            disabled: {
                type: Boolean,
                default: false
            },
        },
        computed: {
            buttonClass() {
                return ['uk-button'].concat(this.class)
            }
        }
    }
</script>

<style scoped>

</style>
