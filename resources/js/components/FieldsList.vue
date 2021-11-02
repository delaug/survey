<template>
    <div class="uk-margin">
        <div class="uk-form-controls">
            <FieldItem v-for="field in fields" :key="field.id" :field="field" :type="type"/>
        </div>
    </div>
</template>

<script>
    import FieldItem from "./FieldItem";
    export default {
        name: "FieldsList",
        components: {FieldItem},
        props: {
            type: {
                type: Number,
                required: true
            },
            fields: {
                type: Array,
                required: true
            },
        }
    }
</script>

<style scoped>

</style>
