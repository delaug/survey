<template>
    <div class="uk-margin">
        <div class="uk-inline uk-width-1">
            <a href="javascript:;" uk-icon="icon: trash"></a>

            <textarea
                :id="id"
                :class="class"
                :value="modelValue"
                :rows="rows"
                @input="update"
            ></textarea>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Field",
        props: {
            modelValue: [String, Number],
            id: {
                type: String,
                default: null
            },
            class: {
                type: String,
                default: null
            },
            rows: {
                type: Number,
                default: 2
            },
        },
        computed: {
            class() {
                return 'uk-textarea';
            }
        },
        methods: {
            update(event) {
                this.$emit('change:modelValue', event.target.value)
            }
        }
    }
</script>

<style scoped>
    a {
        right: -40px;
        left: auto;
        position: absolute;
        top: 0;
        bottom: 0;
        width: 40px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        color: #999;
    }
</style>
