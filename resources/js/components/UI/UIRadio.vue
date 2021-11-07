<template>
    <label>
        <input
            type="radio"
            :id="id"
            :name="name"
            :class="radioClass"
            :value="modelValue"
            @change="changeValue"
        /> <slot></slot>
    </label>
</template>

<script>
    export default {
        name: "ui-radio",
        props: {
            modelValue: [String, Number],
            id: {
                type: String,
                default: null
            },
            name: {
                type: String,
                default: null
            },
            class: {
                type: String,
                default: null
            },
        },
        methods: {
            changeValue(event) {
                this.$emit('change:modelValue', event.target.value)
            }
        },
        computed: {
            radioClass() {
                return ['uk-radio'].concat(this.class)
            }
        }
    }
</script>

<style scoped>

</style>
