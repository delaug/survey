<template>
    <progress
        :class="progressClass"
        :value="progress"
        max="100"
    ></progress>
</template>

<script>
    export default {
        name: "ui-progress",
        props: {
            class: {
                type: String,
                default: null
            },
            max: {
                type: Number,
                default: 100
            },
            value: {
                type: Number,
                required: true
            },
        },
        computed: {
            progress() {
                return (this.value * 100) / this.max
            },
            progressClass() {
                return ['uk-progress'].concat(this.class)
            }
        }
    }
</script>

<style scoped>
    .uk-progress {
        border-radius: unset;
        height: 5px;
    }
</style>
