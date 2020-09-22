<template>
    <div class="">
        <div class="flex flex-col">
            <div v-for="(job, id) in jobs" :key="id" @click="toogleJobModal(job)" class="shadow flex flex-col mb-8 p-2 hover:shadow-md cursor-pointer">
                <div class="flex flex-row items-center mb-2">
                    <h2 class="text-lg text-gray-900 uppercase">{{ job.name }}</h2>
                    <span class="text-md ml-3">Posted On {{ format(job.created_at) }}</span>
                </div>
                <div class="">
                    <p>
                        {{ job.description.substring(0, 200)+"... .. ." }}
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-3 flex flex-col items-center">
            <div v-if="loading" class="fixed inset-0 z-40 bg-gray-300 flex justify-center items-center">
                <div class="sk-cube-grid">
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
            </div>
            <div v-else>
                <button v-if="page" @click="loadJobs();" class="px-3 py-2 rounded text-center mb-3 bg-blue-600 hover:bg-blue-500 text-white">
                    More ...
                </button>
                <p v-else>end of everything....</p>
            </div>
            <p v-if="error">
                {{error}}
            </p>
        </div>
        <div v-if="singleJobLoading">
            <div id="modal" class="fixed  inset-0  rounded-lg flex flex-col  justify-center rounded-lg z-20 ">
                <div @click="job={}; singleJobLoading = false;" class="h-full w-full bg-gray-300">
                </div>
                <Modal :job="job"></Modal>
            </div>
        </div>
    </div>
</template>
<script>
// @ is an alias to /src
import axios from 'axios'
import modal from '../components/Modal';
import { FormatDate } from '../Helpers/helpers.js';

export default {
    name: 'Home',
    components: {
        Modal: modal
    },
    data() {
        return {
            loading: false,
            error: null,
            jobs: [],
            page: 'http://127.0.0.1:8002/api/jobs',
            job: {},
            singleJobLoading: false
        }
    },
    mounted() {
        this.loadJobs();
    },
    methods: {
        loadJobs() {
            this.loading = true;

            axios.get(`${this.page}`, {
                headers: {
                    'Accept': 'application/json'
                }
            }).then(res => {
                this.loading = false;
                if (res.status === 200) {
                    res.data.data.forEach((job) => {
                        this.jobs.push(job);
                    });
                    this.page = res.data.links.next;
                }
            }).catch(err => {
                this.loading = false;
                if (err) {
                    this.error = 'Server error! Try again later.';
                }
            })
        },
        loadOnPageScrollAtBottom() {
            window.onscroll = () => {
                this.loading = true;
                let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
                if (bottomOfWindow) {
                    axios.get(`https://randomuser.me/api/`)
                        .then(response => {
                            this.loading = false;
                            this.jobs.push(response.data.jobs);
                        });
                }
            };
        },
        format(date) {
            return FormatDate(date);
        },
        toogleJobModal(job) {
            this.job = job;
            this.singleJobLoading = !this.singleJobLoading;
        },
        hideModal() {
            this.job = {};
            this.singleJobLoading = false;
        }
    }
};
</script>
<style>
.sk-cube-grid {
    width: 40px;
    height: 40px;
    margin: 100px auto;
}

.sk-cube-grid .sk-cube {
    width: 33%;
    height: 33%;
    background-color: #000000;
    float: left;
    -webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
    animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
}

.sk-cube-grid .sk-cube1 {
    -webkit-animation-delay: 0.2s;
    animation-delay: 0.2s;
}

.sk-cube-grid .sk-cube2 {
    -webkit-animation-delay: 0.3s;
    animation-delay: 0.3s;
}

.sk-cube-grid .sk-cube3 {
    -webkit-animation-delay: 0.4s;
    animation-delay: 0.4s;
}

.sk-cube-grid .sk-cube4 {
    -webkit-animation-delay: 0.1s;
    animation-delay: 0.1s;
}

.sk-cube-grid .sk-cube5 {
    -webkit-animation-delay: 0.2s;
    animation-delay: 0.2s;
}

.sk-cube-grid .sk-cube6 {
    -webkit-animation-delay: 0.3s;
    animation-delay: 0.3s;
}

.sk-cube-grid .sk-cube7 {
    -webkit-animation-delay: 0s;
    animation-delay: 0s;
}

.sk-cube-grid .sk-cube8 {
    -webkit-animation-delay: 0.1s;
    animation-delay: 0.1s;
}

.sk-cube-grid .sk-cube9 {
    -webkit-animation-delay: 0.2s;
    animation-delay: 0.2s;
}

@-webkit-keyframes sk-cubeGridScaleDelay {

    0%,
    70%,
    100% {
        -webkit-transform: scale3D(1, 1, 1);
        transform: scale3D(1, 1, 1);
    }

    35% {
        -webkit-transform: scale3D(0, 0, 1);
        transform: scale3D(0, 0, 1);
    }
}

@keyframes sk-cubeGridScaleDelay {

    0%,
    70%,
    100% {
        -webkit-transform: scale3D(1, 1, 1);
        transform: scale3D(1, 1, 1);
    }

    35% {
        -webkit-transform: scale3D(0, 0, 1);
        transform: scale3D(0, 0, 1);
    }
}
</style>