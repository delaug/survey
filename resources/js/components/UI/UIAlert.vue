<template>
    <div :class="class" uk-alert>
        <a v-if="close" class="uk-alert-close" uk-close></a>
        <slot>{{text}}</slot>
    </div>
</template>

<script>
    export default {
        name: "ui-alert",
        props: {
            text: {
                type: String,
                default: null
            },
            class: {
                type: String,
                default: 'uk-alert-primary'
            },
            close: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped>

</style>
