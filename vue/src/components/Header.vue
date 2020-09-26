<template>
    <nav class="py-2">
        <div class="flex justify-between items-center">
            <div class="">
                <router-link to="/">
                    <span class="text-xl font-italic cursor-pointer">JobHunt</span>
                </router-link>
            </div>
            <div class="relative">
                <svg v-if="menu" @click="menu = false;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-blue-600 md:hidden cursor-pointer">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                <svg v-else @click="menu = true;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-blue-600 md:hidden cursor-pointer">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <div v-if="menu" class="absolute right-0 top-0 mt-10 md:hidden flex flex-col md:flex-row w-48  rounded  shadow  bg-gray-300  px-3 py-3 z-20">
                    <router-link to="/jobs">
                        <span @click="menu = false;" :class="{ 'border-b border-blue-500' : ($route.name === 'Jobs') }" class=" md:mb-0 text-md py-2 border-b border-transparent hover:border-blue-500 cursor-pointer">
                            Find Jobs
                        </span>
                    </router-link>
                    <span @click="menu = false;" :class="{ 'border-b border-blue-500' : ($route.name === 'About') }" class="md:mb-0 text-md py-2 border-b border-transparent hover:border-blue-500 cursor-pointer md:ml-4">
                        <router-link to="/about">
                            About JobHunt
                        </router-link>
                    </span>
                    <div class="mt-4 md:mt-0 flex flex-col md:flex-row justify-end md:items-center">
                        <span @click="modal = true;" class=" md:mb-0 px-2 py-2 border-b border-transparent hover:border-blue-500 w-auto cursor-pointer">Signin</span>
                    </div>
                </div>
                <!-- Large screen -->
                <div class="hidden md:block md:flex md:flex-row md:items-center">
                    <span :class="{ 'border-b border-blue-500' : ($route.name === 'Jobs') }" class="  text-md py-2 border-b border-transparent hover:border-blue-500 cursor-pointer">
                        <router-link to="/jobs">
                            Find Jobs
                        </router-link>
                    </span>
                    <span :class="{ 'border-b border-blue-500' : ($route.name === 'About') }" class=" text-md py-2 border-b border-transparent hover:border-blue-500 cursor-pointer md:ml-4">
                        <router-link to="/about">
                            About JobHunt
                        </router-link>
                    </span>
                    <div class="md:ml-8 flex flex-col md:flex-row justify-end md:items-center">
                        <span v-if="!loggedIn" @click="modal = true;" class="px-2 py-2 border-b border-transparent hover:border-blue-500 w-auto cursor-pointer">Signin</span>
                        <div v-else class="relative">
                            <span @click="toggleUserNav();" :class="{ 'border-b border-blue-500' : ($route.name === 'Dashboard') }" class=" px-2 py-2 border-b border-transparent hover:border-blue-500 cursor-pointer">
                                <router-link to="/dashboard">
                                    Dashboard
                                </router-link>
                            </span>
                            <div v-if="userNav" class="absolute right-0 top-0 mt-10 flex flex-col">
                                <span @click="logout();" class="px-2 py-2 border-b border-transparent hover:border-blue-500 w-auto cursor-pointer">Logout</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Login & register -->
        <div v-if="modal && !loggedIn" class="fixed  inset-0  rounded-lg flex flex-col  justify-center items-center rounded-lg z-20 ">
            <div @click="modal = false;" class="h-full w-full bg-gray-300">
            </div>
            <div class="absolute  bg-white left-0 right-0  mx-auto  max-w-xl shadow-lg rounded-lg p-6 z-30 ">
                <div class="mb-3 flex items-center">
                    <h3 @click="register=false;" class="font-sm  cursor-pointer mr-4" :class="{ 'border-b border-blue-500' : (!register) }">
                        Signin</h3>
                    <h3 @click="register=true;" class="font-sm cursor-pointer " :class="{ 'border-b border-blue-500' : (register) }">Register</h3>
                </div>
                <div v-if="!register">
                    <Signin></Signin>
                </div>
                <div v-if="register">
                    <Register></Register>
                </div>
            </div>
        </div>
    </nav>
</template>
<script>
import Signin from '../components/Signin'
import Register from '../components/Register'
export default {
    name: 'AppHeader',
    components: {
        Signin,
        Register
    },
    data() {
        return {
            modal: false,
            register: false,
            menu: false,
            loggedIn: false,
            userNav: false,
        }
    },
    mounted() {
        this.loggedIn = this.$store.getters.getAuthenticatedUser;
    },
    methods: {
        logout() {
            this.$store.dispatch('logout');
            this.loggedIn = false;
        },
        toggleUserNav() {
            this.userNav = !this.userNav;
        },
        toggleUserAuthenticationModal() {
            this.modal = !this.modal;
        },
        closeUserAuthenticationModal() {
            this.modal = false;
        },
        toggleHamburgerMenu() {
            this.menu = !this.menu;
        }
    }
};
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>