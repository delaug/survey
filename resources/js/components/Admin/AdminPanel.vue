<template>
    <ul uk-tab>
        <router-link
            v-for="route in adminMenu"
            :key="route.path"
            :to="route.path"
            v-slot="{ href, route, navigate, isActive, isExactActive }"
            custom
        >
            <li
                :class="[isActive && 'uk-active', isExactActive && 'uk-active']"
            >
                <a :href="href" @click="navigate">{{ route.meta.title }}</a>
            </li>
        </router-link>
    </ul>
</template>

<script>
    export default {
        name: "AdminPanel",
        computed: {
            adminMenu() {
                const paths = []
                this.$router.options.routes.filter(e => e.meta && e.meta.menu == 'admin')
                    .map(m => m.children.map(c => {
                        paths.push({
                            path: m.path+'/'+c.path
                        })
                    }))

                return paths
            }
        }
    }
</script>

<style scoped>

</style>
