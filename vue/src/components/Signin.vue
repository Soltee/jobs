<template>
    <div class="">
        <form @submit.prevent="loginUser">
            <div class="">
                <div class="flex flex-col mb-6">
                    <label for="email" class="font-md mb-2">Email</label>
                    <input class="px-3 py-2 rounded border border-gray-900" id="email" type="email" v-model="email" />
                    <div v-if="emailErr.length > 0" class="mt-2 flex flex-col">
                        <div v-for="(err, i) in emailErr" :key="i" class=" flex flex-col">
                            <p class="text-red-500 px-2 py-1">{{ err }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mb-6">
                    <label for="password" class="font-md mb-2">Password</label>
                    <input class="px-3 py-2 rounded border border-gray-900" id="password" type="password" v-model="password" />
                    <div v-if="passwordErr.length > 0" class="mt-2 flex flex-col">
                        <div v-for="(err, i) in passwordErr" :key="i" class="flex flex-col">
                            <p class="text-red-500 px-2 py-1">{{ err }}</p>
                        </div>
                    </div>
                </div>
                <div class="">
                    <button type="submit" class="w-full px-6 py-2 text-white bg-blue-600 hover:bg-blue-500 rounded ">
                        <div v-if="loading" class="sk-cube-grid">
                            <div class="sk-cube sk-cube1"></div>
                            <div class="sk-cube sk-cube2"></div>
                            <div class="sk-cube sk-cube3"></div>
                            <div class="sk-cube sk-cube4"></div>
                            <div class="sk-cube sk-cube5"></div>
                            <div class="sk-cube sk-cube6"></div>
                            <div class="sk-cube sk-cube7"></div>
                            <div class="sk-cube sk-cube8"></div>
                            <div class="sk-cube sk-cube9"></div>
                        </div>
                        <span v-else>Login</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    name: 'Signin',
    props: {

    },
    data() {
        return {
            loading: false,
            email: 'test@test.com',
            password: '00000000',
            emailErr: [

            ],
            passwordErr: [],
        }
    },
    methods: {
        loginUser() {
            this.loading = true;

            const data = {
                email: this.email,
                password: this.password
            }
            // this.$store.dispatch('getAndSetAuthenticatedUser');
            // this.loading = false;
            axios.post(`http://localhost:8000/api/login`, data, {
                headers: {
                    'Accept': 'application/json'
                }
            }).then((res) => {
                this.loading = false;
                if (res.status === 200) {
                    localStorage.setItem('_token', res.data.token);
                    this.$store.dispatch('getAndSetAuthenticatedUser');
                    this.$route.push('/');
                }
            }).catch((err) => {
                console.log(err);
                this.loading = false;
                const errors = err.response.data.errors;
                if (errors.email) {
                    this.emailErr = errors.email;
                }
                if (errors.password) {
                    this.passwordErr = errors.password;
                }
            });

        }
    }
};
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>