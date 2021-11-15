<template>
    <div class="uk-margin-small">
        <ui-checkbox
            v-if="type == 1"
            :id="fieldId"
            :name="fieldId"
            :modelValue="value"
            @change="changeValue"
        >
            {{field.text}}
        </ui-checkbox>
        <ui-radio
            v-if="type == 2"
            :id="fieldId"
            :name="name"
            :modelValue="value"
            @change="changeValue"
        >
            {{field.text}}
        </ui-radio>
        <ui-input
            v-if="type == 3"
            :id="fieldId"
            :name="name"
            :label="field.text"
            :modelValue="value"
            @input="updateValue"
        />
        <ui-textarea
            v-if="type == 4"
            :id="fieldId"
            :name="fieldId"
            :modelValue="value"
            @input="updateValue"
            :placeholder="field.text"
        />
    </div>
</template>

<script>
    import {mapState, mapMutations} from 'vuex'
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
            survey: {
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
                    'survey_id': this.survey.id,
                    'user_id': this.user.id,
                    'question_id': this.question.id,
                    'field_id': this.field.id,
                    'value': event.target.value
                })
            },
            changeValue(event) {
                //if(event.target.checked) {
                    // 1 - checkbox
                    if(this.type == 1)
                        this.addAnswer({
                            'survey_id': this.survey.id,
                            'user_id': this.user.id,
                            'question_id': this.question.id,
                            'field_id': this.field.id,
                            'value': event.target.checked
                        })
                    // radio
                    else
                        this.setAnswer({
                            'survey_id': this.survey.id,
                            'user_id': this.user.id,
                            'question_id': this.question.id,
                            'field_id': this.field.id,
                            'value': event.target.checked
                        })
                // } else {
                //     this.removeAnswer(this.field.id)
                // }
            },
        },
        computed: {
            ...mapState({
                user: state => state.auth.user
            }),
            fieldId() {
                return 'field_'+this.field.id
            },
            name() {
                return 'question_'+this.question.id
            },
            value() {
                if(!this.question.answers)
                    return null

                if(this.question.type_id == 1 || this.question.type_id == 2)
                    return this.question.answers.find(f => f.field_id == this.field.id) ? true : false
                else {
                    var answer = this.question.answers.find(f => f.field_id == this.field.id)
                    return answer ? answer.value : null
                }
            }
        }
    }
</script>

<style scoped>

</style>
