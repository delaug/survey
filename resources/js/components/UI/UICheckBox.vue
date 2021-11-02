<template>
    <label>
        <input
            type="checkbox"
            :id="id"
            :name="name"
            :class="checkboxClass"
            :value="modelValue"
            @input="updateCheckbox"
        /> <slot></slot>
    </label>
</template>

<script>
    export default {
        name: "ui-checkbox",
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
            updateCheckbox(event) {
                this.$emit('update:modelValue', event.target.value)
            }
        },
        computed: {
            checkboxClass() {
                return ['uk-checkbox'].concat(this.class)
            }
        }
    }
</script>

<style scoped>

</style>
