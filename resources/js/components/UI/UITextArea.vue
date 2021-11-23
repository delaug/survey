<template>
    <div class="uk-margin uk-margin-small">
        <label v-if="label" class="uk-form-label">{{label}}</label>
        <textarea
            :id="id"
            :name="name"
            :class="textareaClass"
            :placeholder="placeholder"
            :value="modelValue"
            :rows="rows"
            @input="updateTextarea"
        ></textarea>
    </div>
</template>

<script>
    export default {
        name: "ui-textarea",
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
            placeholder: {
                type: String,
                default: null
            },
            label: {
                type: String,
                default: null
            },
            rows: {
                type: Number,
                default: 1
            },
        },
        methods: {
            updateTextarea(event) {
                this.$emit('update:modelValue', event.target.value)
            }
        },
        computed: {
            textareaClass() {
                return ['uk-textarea'].concat(this.class)
            }
        }
    }
</script>

<style scoped>

</style>
