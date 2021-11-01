<template>
    <div v-if="question" class="uk-card uk-card-default uk-margin">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom">{{question.text}}</h3>
                    <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00">Question {{step}} /
                        {{questions_count}}</time></p>
                </div>
            </div>
        </div>
        <div class="uk-card-body">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
        </div>
        <div class="uk-card-footer">
            <div class="uk-grid-small uk-child-width-auto" uk-grid>
                <div>
                    <button class="uk-button uk-button-default" :disabled="step==1" @click="back">Back</button>
                </div>
                <div>
                    <button class="uk-button uk-button-primary" :disabled="step==questions_count" @click="next">Next</button>
                </div>
            </div>
            <div  v-if="step == questions_count" class="uk-grid-small uk-child-width-auto" uk-grid>
                <div>
                    <button class="uk-button uk-button-primary" @click="done">Done</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Question",
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
                return this.questions[this.step-1]
            }
        }
    }
</script>

<style scoped>

</style>
