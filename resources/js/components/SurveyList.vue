<template>
    <SurveyItem v-for="survey in surveys" :key="survey.id" :survey="survey"/>
    <Loader v-if="loading"/>
    <Observer @intersect="intersected"/>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex';
    import Observer from "../components/Observer";
    import SurveyItem from "./SurveyItem";
    import Loader from "./Loader";

    export default {
        name: "SurveyList",
        components: {Loader, SurveyItem, Observer},
        data() {
            return {
                loading: false,
            }
        },
        computed: {
            ...mapState({
                surveys: state => state.surveys.surveys,
                current_page: state => state.surveys.current_page,
                last_page: state => state.surveys.last_page
            }),
        },
        methods: {
            ...mapActions({getSurveys: 'surveys/getSurveys'}),
            ...mapMutations({
                clearSurveys: 'surveys/CLEAR_SURVEYS',
                setCurrentPage: 'surveys/SET_CURRENT_PAGE'
            }),
            next() {
                this.getSurveys()
            },
            intersected() {
                this.loading = true
                this.getSurveys().then(() => {
                    this.loading = false
                })
            }
        },
        mounted() {
            this.clearSurveys();
            this.setCurrentPage(0);
        }
    }
</script>

<style scoped>

</style>
