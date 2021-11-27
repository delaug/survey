<template>
    <div
        v-if="data"
        class="uk-overflow-auto">
        <table
            class="uk-table uk-table-small uk-table-striped uk-table-responsive uk-table-hover uk-table-middle uk-table-divider uk-text-small">
            <thead>
            <tr>
                <th
                    v-for="title in titles"
                    :key="'th_'+title.field"
                    :class="{'uk-width-small':['email_verified_at','created_at','updated_at','deleted_at'].includes(title.field)}"
                >
                    {{title.name}}
                </th>
                <th v-if="colActions" class="uk-table-small uk-text-nowrap uk-text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in data" :key="'tr_'+row.id">
                <td
                    v-for="(val, idx) in titles" :key="'td_'+idx"
                >
                    {{ prepareVal(idx, row[val.field]) }}
                </td>
                <td v-if="colActions" class="uk-text-nowrap uk-text-center">
                    <a
                        href="javascript:;"
                        class="uk-icon-link uk-margin-small-right uk-text-primary"
                        uk-icon="file-edit"
                        @click="onEdit(row.id)"
                    ></a>
                    <a
                        href="javascript:;"
                        class="uk-icon-link uk-margin-small-right uk-text-danger"
                        uk-icon="trash"
                        @click="onDelete(row.id)"
                    ></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "ui-table",
        props: {
            colActions: {type: Boolean, default: true},
            data: {type: Array, required: true},
            titles: {type: Array},
        },
        emits:['onEdit','onDelete'],
        methods: {
            prepareVal(idx, val) {
                if(!val || typeof val != 'object') {
                    return val
                }
                return val.length != undefined ? val.map(v => v.name).join(',') : val.name
            },
            onEdit(id) {
                this.$emit('onEdit',id)
            },
            onDelete(id) {
                this.$emit('onDelete',id)
            }
        }
    }
</script>

<style scoped>

</style>
