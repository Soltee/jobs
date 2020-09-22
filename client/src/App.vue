<template>
    <div id="nav" class="bg-gray-300 px-6 py-4 text-gray-900">
        <div id="nav" class="max-w-screen-xl mx-auto text-gray-900">
            <AppHeader></AppHeader>
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import AppHeader from '@/components/Header.vue'

export default {
    name: 'App',
    components: {
        AppHeader,
    },
    computed: {
        user() {
            return this.$store.dispatch('getAndSetAuthenticatedUser');
        }
    }
};
</script>
<style lang="scss">
@import './assets/css/tailwind.css'
</style>