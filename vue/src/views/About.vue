<template>
    <div class="about">
        <h1>This is an about page</h1>
    </div>
</template>
<script>
// @ is an alias to /src
// import axios from 'axios';
export default {
    name: 'About',
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
    }
};
</script>