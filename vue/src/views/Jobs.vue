<template>
    <div class="relative">
        <!-- search -->
        <div class="mb-8 ">
            <div class="flex  items-center">
                <form @submit.prevent="">
                    <div>
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="flex flex-col ">
                                <span class="text-lg px-3 py-2  rounded">Keyword</span>
                                <div class="relative flex w-full">
                                    <input @keyup="search = true; searchJobs();" class="pl-12 pr-6 py-3 rounded text-lg border border-blue-500" v-model="keyword" />
                                </div>
                            </div>
                            <div class="flex flex-col md:ml-3">
                                <span class="text-lg px-3 py-2  rounded">Salary</span>
                                <div class="relative flex w-full">
                                    <input type="number" @keyup="search = true; searchJobs();" class="px-3 w-40 py-3 rounded text-lg border border-blue-500" v-model="from" />
                                    <input type="number" @keyup="search = true; searchJobs();" class="ml-3 px-3 w-40 py-3 rounded text-lg border border-blue-500" v-model="to" />
                                </div>
                            </div>
                            <div class="flex flex-col ml-3">
                                <span class="text-lg text-transparent px-3 py-2  rounded">Clear</span>
                                <button @click="resetAll();" class="px-6 bg-red-600 text-white hover:bg-red-500 py-3 rounded text-lg" type="button">
                                    Clear
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Results -->
        <div class="relative">
            <div class="mb-2 flex justify-center items-center">
                {{ total }} jobs found
                <span v-if="search"> for {{ keyword }}.</span>
            </div>
            <div class="flex flex-col">
                <!-- searched jobs -->
                <div v-if="search">
                    <div v-for="(job, id) in jobsSearch" :key="id" @click="toogleJobModal(job)" class="shadow flex flex-col mb-10 px-3 py-3 hover:shadow-lg cursor-pointer">
                        <div class="flex flex-col mb-2">
                            <h2 class="text-lg text-gray-900 capitalize">{{ job.name }}</h2>
                            <span class="text-sm mt-2">Posted On {{ format(job.created_at) }}</span>
                        </div>
                        <div class="mt-5">
                            <p>
                                {{ job.description.substring(0, 400)+"... .. ." }}
                            </p>
                            <div class="mt-4">
                                <span class="mr-2 px-2 py-2 bg-blue-400 text-white rounded" v-for="(tag, i) in job.tags.split(',')" :key="i">
                                    {{ tag }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Regular jobs without search -->
                <div v-else>
                    <div v-for="(job, id) in jobs" :key="id" @click="toogleJobModal(job)" class="shadow flex flex-col mb-10 px-3 py-3 hover:shadow-lg cursor-pointer">
                        <div class="flex flex-col mb-2">
                            <h2 class="text-lg text-gray-900 capitalize">{{ job.name }}</h2>
                            <span class="text-sm mt-2">Posted On {{ format(job.created_at) }}</span>
                        </div>
                        <div class="mt-5">
                            <p>
                                {{ job.description.substring(0, 400)+"... .. ." }}
                            </p>
                            <div class="mt-4">
                                <span class="mr-2 px-2 py-2 bg-blue-400 text-white rounded" v-for="(tag, i) in job.tags.split(',')" :key="i">
                                    {{ tag }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 flex flex-col items-center">
                <!-- Loading && error message -->
                <div v-if="loading" class="z-40 bg-gray-300 flex justify-center items-center">
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
                    <p v-if="error" class="text-red-600 font-black">
                        {{error}}
                    </p>
                    <p v-else>End of everything....</p>
                </div>
            </div>
            <!-- single Job Modal -->
            <div v-if="singleJobLoading">
                <div id="modal" class="fixed  inset-0  rounded-lg flex flex-col  justify-center rounded-lg z-20 py-8">
                    <div @click="job={}; singleJobLoading = false;" class="h-full w-full bg-gray-300">
                    </div>
                    <div class="absolute  bg-white left-0 right-0  mx-auto  max-w-3xl shadow-lg rounded-lg p-6 z-30 h-screen overflow-y-scroll">
                        <div class="flex justify-end items-center absolute right-0 top-0 mt-3 mr-3">
                            <svg @click="hideModal();" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="flex justify-end w-8 h-8 text-red-600  cursor-pointer">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </div>
                        <Modal :job="job"></Modal>
                    </div>
                </div>
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
    name: 'Jobs',
    components: {
        Modal: modal
    },
    data() {
        return {
            loading: false,
            error: null,
            jobs: [],
            endpoint: 'http://127.0.0.1:8000/api/jobs',
            searchNextPage: '',
            job: {},
            singleJobLoading: false,
            search: false,
            keyword: '',
            from: 0,
            to: 0,
            jobsSearch: [],
            total: 0,
        }
    },
    mounted() {
        this.loadFromBackend();
        this.loadOnPageScrollAtBottom();
    },
    methods: {
        searchJobs() {
            this.jobsSearch = [];
            this.endpoint = `http://localhost:8000/api/jobs?keyword=${this.keyword}&from=${this.from}&to=${this.to}`;

            this.loadFromBackend();
        },
        loadFromBackend() {
            this.loading = true;

            axios.get(`${this.endpoint}`, {
                headers: {
                    'Accept': 'application/json'
                }
            }).then(res => {
                this.loading = false;
                if (res.status === 200) {
                    if (this.search) {


                        if (this.jobsSearch.length > 0) {
                            res.data.data.forEach((job) => {
                                this.jobsSearch.push(job);
                            });
                        } else {
                            this.jobsSearch = res.data.data;
                        }
                    } else {
                        res.data.data.forEach((job) => {
                            this.jobs.push(job);
                        });

                    }
                    if (res.data.data.length < 1) {
                        this.error = 'No more jobs.';
                    }
                    this.endpoint = res.data.next_page_url;

                    this.total = res.data.total;
                }
            }).catch(err => {
                this.loading = false;
                if (err) {
                    this.error = 'Oops! There must be some problem.But you can try again later.';
                }
            })

        },
        loadOnPageScrollAtBottom() {
            window.onscroll = () => {
                let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
                if (bottomOfWindow && this.endpoint) {
                    this.loadFromBackend();
                }
            };
        },
        resetAll() {
            this.search = false;
            this.jobsSearch = [];
            this.jobs = [];
            this.keyword = '';
            this.from = 0;
            this.to = 0;
            this.endpoint = 'http://localhost:8000/api/jobs';
            this.loadFromBackend();
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
    width: 20px;
    height: 20px;
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