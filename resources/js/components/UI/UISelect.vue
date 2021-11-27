<template>
    <div class="uk-margin uk-margin-small">
        <label v-if="label" :class="labelClass" :htmlFor="id">{{label}}</label>

        <select
            :class="selectClass"
            :id="id"
            :name="name"
            @change="updateInput"
            v-model="selected"
        >
            <option
                v-for="option in options"
                :key="option.id"
                :value="option.id"
            >
                {{option[value_field]}}
            </option>

        </select>
        <small v-if="error" class="uk-text-danger">{{error}}</small>
    </div>
</template>

<script>
    export default {
        name: "ui-select",
        props: {
            modelValue: {type: Number},
            id: {
                type: String,
                default: null
            },
            value_field: {
                type: String,
                default: 'name'
            },
            options: {
                type: Array,
                default: []
            },
            name: {
                type: String,
                default: null
            },
            class: {
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
        emits: ['selected'],
        data(){
            return {
                selected: []
            }
        },
        methods: {
            updateInput() {
                this.$emit('selected', this.selected)
            }
        },
        computed: {
            selectClass() {
                return ['uk-select', {'uk-form-danger': this.error}].concat(this.class)
            },
            labelClass() {
                return ['uk-form-label', {'uk-text-danger': this.error}].concat(this.class)
            },
        },
        mounted() {
            this.selected = this.modelValue
        },
        watch: {
            modelValue() {
                this.selected = this.modelValue
            }
        }
    }
</script>

<style scoped>

</style>
