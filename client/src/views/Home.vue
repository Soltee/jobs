<template>
    <div class="">
    </div>
</template>
<script>
// @ is an alias to /src
// import axios from 'axios'
// import modal from '../components/Modal';
import { FormatDate } from '../Helpers/helpers.js';

export default {
    name: 'Home',
    components: {

    },
    data() {
        return {
            loading: false,
            error: null,
            jobs: [],
            page: 'http://127.0.0.1:8000/api/jobs',
        }
    },
    mounted() {
        this.loadJobs();
    },
    methods: {
        loadJobs() {

        },
        format(date) {
            return FormatDate(date);
        }
    }
};
</script>
<style>
</style>