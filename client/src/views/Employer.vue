<template>
    <div class="about">
        <h1>This is an Employer page</h1>
    </div>
</template>
<script>
// @ is an alias to /src
import axios from 'axios';
export default {
    name: 'Employer',
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