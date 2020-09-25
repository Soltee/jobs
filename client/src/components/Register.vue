<template>
    <div class="">
        <div class="mb-2">
            <span @click="isEmployer = true;">Employer</span>
        </div>
        <form @submit.prevent="registerUser">
            <div class="">
                <div class="flex flex-col mb-6">
                    <label for="name" class="font-md mb-2">Name</label>
                    <input class="px-3 py-2 rounded border border-gray-900" id="name" type="name" v-model="name" />
                    <div v-if="nameErr.length > 0" class="mt-2 flex flex-col">
                        <div v-for="(err, i) in nameErr" :key="i" class=" flex flex-col">
                            <p class="text-red-500 px-2 py-1">{{ err }}</p>
                        </div>
                    </div>
                </div>
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
                <div class="flex flex-col mb-6">
                    <label for="confirm" class="font-md mb-2">Confirm</label>
                    <input class="px-3 py-2 rounded border border-gray-900" id="confirm" type="password" v-model="confirm" />
                    <div v-if="confirmErr.length > 0" class="mt-2 flex flex-col">
                        <div v-for="(err, i) in confirmErr" :key="i" class="flex flex-col">
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
                        <span v-else>Register</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    name: 'Register',
    props: {

    },
    data() {
        return {
            loading: false,
            name: 'Test',
            email: 'test@test.com',
            password: '00000000',
            confirm: '00000000',
            nameErr: [],
            emailErr: [],
            passwordErr: [],
            confirmErr: [],
            isEmployer: false
        }
    },
    methods: {
        registerUser() {
            this.loading = true;

            const data = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.confirm,
                is_employer: this.isEmployer
            }
            // this.$store.dispatch('getAndSetAuthenticatedUser');
            // this.loading = false;
            axios.post(`http://127.0.0.1:8000/api/register`, data, {
                headers: {
                    'Accept': 'application/json'
                }
            }).then((res) => {
                this.loading = false;
                if (res.status === 200) {
                    localStorage.setItem('_token', res.data._token);
                    this.$store.dispatch('setToken');
                    this.$store.dispatch('getAndSetAuthenticatedUser');
                }
            }).catch((err) => {
                console.log(err);
                this.loading = false;
                const { name, email, password } = err.response.data.errors;
                if (name) {
                    this.nameErr = name;
                }
                if (email) {
                    this.emailErr = email;
                }
                if (password) {
                    this.passwordErr = password;
                }
            });

        }
    }
};
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>