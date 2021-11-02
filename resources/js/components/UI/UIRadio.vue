<template>
    <label>
        <input
            type="radio"
            :id="id"
            :name="name"
            :class="radioClass"
            :value="modelValue"
            @input="updateRadio"
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
            updateRadio(event) {
                this.$emit('update:modelValue', event.target.value)
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
