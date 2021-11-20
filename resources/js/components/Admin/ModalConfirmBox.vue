<template>
    <div
        :id="id"
        class="uk-flex-top"
        uk-modal
    >
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">{{text}}</h2>
                <p>With id: {{target_id}}</p>
            </div>

            <div class="uk-modal-footer uk-text-right">
                <ui-button :class="'uk-button-default uk-modal-close'" @click="cancel">No</ui-button>
                <ui-button :class="'uk-button-danger uk-margin-small-left'" @click="confirm">Yes</ui-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ModalConfirmBox",
        props: {
            id: {type: String, default: 'modal-confirm-box'},
            text: {type: String, default: 'Are you sure delete item?'},
        },
        emits: ['confirm','cancel'],
        data() {
            return {
                target_id: null
            }
        },
        methods: {
            confirm() {
                this.$emit('confirm', this.target_id)
                this.hide()
            },
            cancel() {
                this.$emit('cancel')
            },
            show(id) {
                this.target_id = id
                this.UIkit.modal('#'+this.id).show()
            },
            hide() {
                this.UIkit.modal('#'+this.id).hide()
            }
        }
    }
</script>

<style scoped>
    .uk-modal-header, .uk-modal-footer {
        background: #f8f8f8;

    }
</style>
