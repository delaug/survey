<template>

    <ul class="uk-child-width-expand" uk-tab>
        <li
            v-if="questions"
            v-for="(question, index) in questions"
            :key="index"
            :class="{'uk-active': index === item_index}"
        >
            <a @click="onSetIndex(index)">{{index+1}}{{question.id == null ? '*' : ''}}</a>
        </li>
        <li>
            <a @click="onNew"><span uk-icon="icon: plus"></span></a>
        </li>
    </ul>
</template>

<script>
    import {mapState, mapMutations} from 'vuex';

    export default {
        name: "QuestionTabs",
        computed: {
            ...mapState({
                questions: state => state.admin.questions.questions,
                item_index: state => state.admin.questions.item_index,
            })
        },
        methods: {
            ...mapMutations({
                newQuestion: 'admin/questions/NEW_QUESTION',
                setIndex: 'admin/questions/SET_ITEM_INDEX',
            }),
            onNew() {
                this.newQuestion();
            },
            onSetIndex(index) {
                this.setIndex(index)
            }
        }
    }
</script>

<style scoped>

</style>
