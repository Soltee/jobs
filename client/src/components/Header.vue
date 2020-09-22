<template>
    <div class="flex justify-around items-center py-3 mb-3">
        <router-link to="/">Home</router-link> |
        <router-link to="/login">Login</router-link>
    </div>
</template>
<script>
export default {
    name: 'AppHeader',
    props: {

    }
};
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>