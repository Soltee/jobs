<template>
    <div>
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
        <!--   Create Job Modal -->
        <!-- Load If Employer -->
        <div v-if="user.is_employer">
            <Create></Create>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Create from '../../components/Create.vue';

export default {
    name: 'Dashboard',
    components: {
        Create
    },
    data() {
        return {
            modal: false,
            endpoint: 'http://localhost:8000/api/employer/jobs',
            user: {}
        }
    },
    mounted() {
        this.user = this.$store.getters.getAuthenticatedUser;
        this.getEmployerJobs();
    },
    methods: {
        toggleModal() {
            this.modal = !this.modal;
        },
        getEmployerJobs() {
            this.loading = true;
            axios.get(`${this.endpoint}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('_token')}`
                }
            }).then(res => {
                this.loading = false;
                if (res.status === 200) {
                    res.data.data.forEach((job) => {
                        this.jobs.push(job);
                    });
                }
            }).catch(err => {
                this.loading = false;
                console.log(err);
            });

        }
    }
};
</script>