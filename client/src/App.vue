<template>
    <div id="nav" class="bg-gray-200 px-6 py-4 text-gray-900">
        <div id="nav" class="max-w-screen-xl mx-auto text-gray-900">
            <AppHeader></AppHeader>
            <div id="nav" class="max-w-2xl mx-auto text-gray-900 mt-8">
                <router-view></router-view>
            </div>
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