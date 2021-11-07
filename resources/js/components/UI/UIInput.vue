<template>
    <div>
        <label v-if="label" :class="labelClass" :htmlFor="id">{{label}}</label>
        <input
            :type="type"
            :id="id"
            :name="name"
            :class="inputClass"
            :placeholder="placeholder"
            :value="modelValue"
            @input="updateInput"
        />
        <small v-if="error" class="uk-text-danger">{{error}}</small>
    </div>
</template>

<script>
    export default {
        name: "ui-input",
        props: {
            modelValue: [String, Number],
            type: {
                type: String,
                default: 'text'
            },
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
            placeholder: {
                type: String,
                default: null
            },
            label: {
                type: String,
                default: null
            },
            error: {
                type: String,
                default: null
            },
        },
        methods: {
            updateInput(event) {
                this.$emit('update:modelValue', event.target.value)
            }
        },
        computed: {
            inputClass() {
                return ['uk-' + (['text', 'email', 'password'].includes(this.type) ? 'input' : this.type), {'uk-form-danger': this.error}].concat(this.class)
            },
            labelClass() {
                return ['uk-form-label', {'uk-text-danger': this.error}].concat(this.class)
            }
        }
    }
</script>

<style scoped>

</style>
