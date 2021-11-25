<template>
    <div
        v-if="question"
        class="uk-card uk-card-default uk-card-small uk-card-body uk-margin-small">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-expand">
                    <div class="question-trash">
                        <a @click="remove"><span uk-icon="icon: trash"></span></a>
                    </div>
                    <h3 class="uk-card-title uk-heading-bullet">Question #{{index+1}}</h3>
                    <div class="uk-grid-small" uk-grid>
                        <div class="uk-width-1-2">
                            <ui-select
                                :modelValue="1"
                                :options="question_types"
                            />
                        </div>
                        <div class="uk-width-1-2">
                            <ui-input
                                :modelValue="100"
                            />
                        </div>
                    </div>


                    <ui-textarea
                        :rows="4"
                        :modelValue="'Lorem ipsum dolor sit amet, consectetur iste, iusto magni nam nihil tempore tenetur! Atque, eos, perspiciatis. Animi harum illo natus neque omnis possimus quis unde.'"
                    />
                </div>
            </div>
        </div>
        <div class="uk-card-body">
            <Field
                v-model="textarea"
                @input="update"
            />

            <ui-button :class="'uk-button-default uk-width-1-1'">
                <span uk-icon="icon: plus"></span>
            </ui-button>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import Field from "./Field";

    export default {
        name: "Question",
        components: {Field},
        props: {
            question: {
                type: Object,
                required: true
            },
            index: {
                type: [Number, String],
                required: true
            }
        },
        data() {
            return {
                textarea: 'long text',
            }
        },
        methods: {
            ...mapActions({
                deleteQuestion: 'admin/questions/deleteQuestion',
            }),
            update(event) {
                this.textarea = event.target.value
            },
            remove() {
                this.deleteQuestion(
                    {
                        id: this.question ? this.question.id : null,
                        index: this.index,
                    }
                )
            }
        },
        computed: {
            ...mapState({
                question_types: state => state.admin.question_types.question_types
            })
        }
    }
</script>

<style scoped>
    .uk-form-icon-flip {
        right: -40px;
        left: auto;
    }

    .question-trash {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1;
        height: 22px;
        font-size: 0.875rem;
        display: flex;
        justify-content: center;
        align-items: center;
        line-height: 0;
        border-radius: 2px;
        text-transform: uppercase;
    }
</style>
