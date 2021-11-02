<template>
    <div class="uk-margin-small">
        <ui-checkbox
            v-if="type == 1"
            :name="name"
        >
            {{field.text}}
        </ui-checkbox>
        <ui-radio
            v-if="type == 2"
            :name="name"
        >
            {{field.text}}
        </ui-radio>
        <ui-input
            v-if="type == 3"
            :name="name"
            :placeholder="field.text"
        />
        <ui-textarea
            v-if="type == 4"
            :name="name"
            :placeholder="field.text"
        />
    </div>
</template>

<script>
    export default {
        name: "FieldItem",
        props: {
            type: {
                type: Number,
                required: true
            },
            field: {
                type: Array,
                required: true
            },
        },
        computed: {
            name() {
                // 2 - radio btn
                return 'q'+this.field.question_id+'_t'+this.type + ((this.type != 2) ? '_f'+this.field.id : '');
            }
        }
    }
</script>

<style scoped>

</style>
