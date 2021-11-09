<template>
    <div class="uk-margin">
        <div class="uk-form-controls">
            <FieldItem
                v-for="field in fields"
                :key="field.id"
                :field="field"
                :question="question"
                :type="type"
                :survey="survey"
            />
        </div>
    </div>
</template>

<script>
    import FieldItem from "./FieldItem";
    export default {
        name: "FieldsList",
        components: {FieldItem},
        props: {
            modelValue: [Object],
            type: {
                type: Number,
                required: true
            },
            survey: {
                type: Object,
                required: true
            },
            fields: {
                type: Object,
                required: true
            },
            question: {
                type: Object,
                required: true
            },
        }
    }
</script>

<style scoped>

</style>
