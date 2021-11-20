<template>
    <div
        v-if="data"
        class="uk-overflow-auto">
        <table
            class="uk-table uk-table-small uk-table-striped uk-table-responsive uk-table-hover uk-table-middle uk-table-divider">
            <thead>
            <tr>
                <th
                    v-for="(item, index) in data[0]"
                    :key="'th_'+item"
                    :class="{'uk-width-small':['email_verified_at','created_at','updated_at','deleted_at'].includes(index)}"
                >
                    {{index}}
                </th>
                <th v-if="colActions" class="uk-table-small uk-text-nowrap uk-text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in data" :key="'tr_'+row.id">
                <td
                    v-for="(val, idx) in row" :key="'td_'+idx"
                >
                    {{ prepareVal(val) }}
                </td>
                <td v-if="colActions" class="uk-text-nowrap uk-text-center">
                    <a
                        href="#"
                        class="uk-icon-link uk-margin-small-right uk-text-primary"
                        uk-icon="file-edit"
                        @click="onEdit(row.id)"
                    ></a>
                    <a
                        href="#"
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
            data: {type: Array, required: true}
        },
        emits:['onEdit','onDelete'],
        methods: {
            prepareVal(val) {
                if(!val || typeof val != 'object') {
                    return val
                }

                return val.map(v => v.name).join(',')
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
