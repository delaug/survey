<template>
    <div
        id="modal-survey-form"
        class="uk-modal-container uk-flex-top"
        uk-modal
    >
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Survey: {{id ? 'Edit' : 'New'}}</h2>
            </div>
            <div v-if="form && form.media && form.media.public_path" class="uk-card-media-top">
                <ul class="uk-iconnav panel-image-tools">
                    <li><a href="javascript:;" uk-icon="icon: link" @click="onDetachMedia"></a></li>
                </ul>
                <img :src="form.media.public_path" alt=""/>
            </div>
            <div class="uk-modal-body">
                <Loader v-if="loading"/>

                <div v-if="form && !form.media" class="uk-margin">
                    <div uk-form-custom>
                        <input type="file" @change="onUpload">
                        <button class="uk-button uk-button-default" type="button" tabindex="-1"><span
                            uk-icon="icon: upload"></span> Upload
                        </button>
                    </div>
                </div>

                <ui-input
                    :id="'title'"
                    :name="'title'"
                    :label="'title'"
                    :modelValue="form && form.title"
                    @input="updateData"
                />
                <ui-textarea
                    :id="'description'"
                    :name="'description'"
                    :label="'description'"
                    :rows="4"
                    :modelValue="form && form.description"
                    @input="updateData"
                />
                <ui-select
                    :id="'user_id'"
                    :name="'user_id'"
                    :label="'user_id'"
                    :modelValue="form && form.user_id"
                    :options="users"
                    @selected="selectedUser"
                />
                <ui-checkbox
                    :id="'is_publish'"
                    :name="'is_publish'"
                    :type="'checkbox'"
                    :modelValue="form && form.is_publish"
                    @change="changePublish"
                >
                    is_publish
                </ui-checkbox>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <ui-button :class="'uk-button-default uk-modal-close'">Cancel</ui-button>
                <ui-button :class="'uk-button-primary uk-margin-small-left'" :loading="loading" @click="createOrUpdate">
                    Save
                </ui-button>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from "../Loader";
    import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';

    export default {
        name: "ModalSurveyForm",
        components: {Loader},
        props: {
            mode: {type: Boolean}
        },
        data() {
            return {}
        },
        computed: {
            ...mapState({
                users: state => state.admin.users.users,
                form: state => state.admin.surveys.form,
                id: state => state.admin.surveys.id,
                loading: state => state.admin.surveys.loading,
            }),
            ...mapGetters({
                currentQuestion: 'admin/questions/currentQuestion'
            })
        },
        methods: {
            ...mapActions({
                getSurvey: 'admin/surveys/getSurvey',
                postSurvey: 'admin/surveys/postSurvey',
                updateSurvey: 'admin/surveys/updateSurvey',
                deleteSurvey: 'admin/surveys/deleteSurvey',
                postMedia: 'admin/media/postMedia',
            }),
            ...mapMutations({
                updateFormField: 'admin/surveys/UPDATE_FORM_FIELD',
            }),
            updateData(event) {
                this.updateFormField({field: event.target.id, value: event.target.value})
            },
            selectedUser(selected) {
                this.updateFormField({field: 'user_id', value: selected})
            },
            changePublish(event) {
                this.updateFormField({field: event.target.id, value: event.target.checked})
            },
            createOrUpdate() {
                this.id
                    ? this.updateSurvey(this.id)
                        .then(() => this.UIkit.modal('#modal-survey-form').hide())
                    : this.postSurvey()
                        .then(() => this.UIkit.modal('#modal-survey-form').hide())
            },
            onUpload(event) {
                this.postMedia(event.target.files[0]).then(response => {
                    this.updateFormField({field: 'media', value: response.data})
                    this.updateFormField({field: 'media_id', value: response.data.id})
                })
            },
            onDetachMedia() {
                this.updateFormField({field: 'media', value: null})
                this.updateFormField({field: 'media_id', value: null})
            }
        }
    }
</script>

<style scoped>
    .uk-modal-header, .uk-modal-footer {
        background: #f8f8f8;

    }

    .panel-image-tools {
        position: absolute;
        right: 0;
        background-color: white;
        padding: 10px;
        padding-left: unset;
    }
</style>
