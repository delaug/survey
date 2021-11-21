<template>
    <div>
        <label v-if="label" :class="labelClass" :htmlFor="id">{{label}}</label>

        <select
            :class="selectClass"
            :id="id"
            :name="name"
            v-model="selected"
            multiple
            @change="updateInput"
        >
            <option
                v-for="option in options"
                :key="option.id"
                :value="option.id"
            >
                {{option.name}}
            </option>

        </select>
        <small v-if="error" class="uk-text-danger">{{error}}</small>
    </div>
</template>

<script>
    export default {
        name: "ui-multiselect",
        props: {
            modelValue: {type: Array},
            id: {
                type: String,
                default: null
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
