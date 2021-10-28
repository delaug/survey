<template>
    <ul class="uk-navbar-nav">
        <router-link
            v-for="route in items"
            :key="route.path"
            :to="route.path"
            v-slot="{ href, route, navigate, isActive, isExactActive }"
            custom
        >
            <li
                :class="[isActive && 'uk-active', isExactActive && 'uk-active']"
            >
                <a :href="href" @click="navigate">{{ route.name }}</a>
            </li>
        </router-link>
    </ul>
</template>

<script>
    export default {
        name: 'MainMenu',
        props: {
            'items': [Array]
        }
    }
</script>

<style scoped>

</style>
