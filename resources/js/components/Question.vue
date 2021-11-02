<template>
    <div v-if="question" class="uk-card uk-card-default uk-margin">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom">{{question.text}}</h3>
                    <p class="uk-text-meta uk-margin-remove-top">
                        <time datetime="2016-04-01T19:00">Question {{step}} /
                            {{questions_count}}
                        </time>
                    </p>
                </div>
            </div>
        </div>
        <div class="uk-card-body">
            <FieldsList :type="question.type.id" :fields="question.fields"/>
        </div>
        <div class="uk-card-footer">
            <div class="uk-grid-small uk-child-width-auto" uk-grid>
                <div>
                    <ui-button :class="'uk-button-default'" @click="back" :disabled="step==1">Back</ui-button>
                </div>
                <div v-if="step != questions_count">
                    <ui-button :class="'uk-button-primary'" @click="next">Next</ui-button>
                </div>
                <div v-else>
                    <ui-button :class="'uk-button-primary'" @click="done">Done</ui-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FieldsList from "./FieldsList";
    export default {
        name: "Question",
        components: {FieldsList},
        props: {
            questions: {
                type: Array,
                required: true
            },
            questions_count: {
                type: Number,
                required: true
            }
        },
        data() {
            return {
                step: 1
            }
        },
        methods: {
            next() {
                this.step++;
            },
            back() {
                this.step--;
            },
            done() {

            },
        },
        computed: {
            question() {
                return this.questions[this.step - 1]
            }
        }
    }
</script>

<style scoped>

</style>
