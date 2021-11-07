<template>
    <label>
        <input
            type="checkbox"
            :id="id"
            :name="name"
            :class="checkboxClass"
            :value="modelValue"
            @change="changeValue"
        /> <slot></slot>
    </label>
</template>

<script>
    export default {
        name: "ui-checkbox",
        props: {
            modelValue: [Boolean],
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
            checkboxClass() {
                return ['uk-checkbox'].concat(this.class)
            }
        }
    }
</script>

<style scoped>

</style>
