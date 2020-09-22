<template>
    <div class="mx-auto max-w-screen-md min-h-screen flex justify-center items-center rounded shadow">
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
                        <span v-if="loading">Loading ......</span>
                        <span v-else>Login</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
// @ is an alias to /src
import axios from 'axios';
export default {
    name: 'Login',
    components: {

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
            axios.post(`http://127.0.0.1:8001/api/login`, data, {
                headers: {
                    'Accept': 'application/json'
                }
            }).then((res) => {
                this.loading = false;
                if (res.status === 200) {
                    this.$store.dispatch('getAndSetAuthenticatedUser');
                    this.$store.dispatch('setToken');
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