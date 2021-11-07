<template>
    <div class="uk-margin-small">
        <ui-checkbox
            v-if="type == 1"
            :id="fieldId"
            :name="fieldId"
            @change="changeValue"
        >
            {{field.text}}
        </ui-checkbox>
        <ui-radio
            v-if="type == 2"
            :id="fieldId"
            :name="name"
            @change="changeValue"
        >
            {{field.text}}
        </ui-radio>
        <ui-input
            v-if="type == 3"
            :id="fieldId"
            :name="name"
            :placeholder="field.text"
            @input="updateValue"
        />
        <ui-textarea
            v-if="type == 4"
            :id="fieldId"
            :name="fieldId"
            @input="updateValue"
            :placeholder="field.text"
        />
    </div>
</template>

<script>
    import {mapMutations} from 'vuex'
    export default {
        name: "FieldItem",
        props: {
            type: {
                type: Number,
                required: true
            },
            field: {
                type: Object,
                required: true
            },
            question: {
                type: Object,
                required: true
            },
        },
        methods: {
            ...mapMutations({
                'setAnswer': 'answers/SET_ANSWER',
                'addAnswer': 'answers/ADD_ANSWER',
                'removeAnswer': 'answers/REMOVE_ANSWER',
            }),
            updateValue(event) {
                this.addAnswer({
                    'field_id': this.field.id,
                    'type_id': this.type,
                    'value': event.target.value
                })
            },
            changeValue(event) {
                if(event.target.checked) {
                    // 1 - checkbox
                    if(this.type == 1)
                        this.addAnswer({
                            'field_id': this.field.id,
                            'type_id': this.type,
                            'value': event.target.checked
                        })
                    // radio
                    else
                        this.setAnswer({
                            'field_id': this.field.id,
                            'type_id': this.type,
                            'value': event.target.checked
                        })
                } else {
                    this.removeAnswer(this.field.id)
                }
            },
        },
        computed: {
            fieldId() {
                return 'field_'+this.field.id
            },
            name() {
                return 'question_'+this.question.id
            }
        }
    }
</script>

<style scoped>

</style>
