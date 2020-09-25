<template>
    <div class="">
        <div class="p-6 shadow-md flex flex-row justify-center items-center">
            <div class="p-6  flex flex-col w-full ">
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
    </div>
</template>
<script>
// @ is an alias to /src
// import axios from 'axios';
import Signin from '../components/Signin'
import Register from '../components/Register'

export default {
    name: 'Login',
    components: {
        Signin,
        Register
    },
    data() {
        return {
            register: false,
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