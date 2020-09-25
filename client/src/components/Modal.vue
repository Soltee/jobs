<template>
    <div class="">
        <div class="flex flex-col">
            <div class="mb-4 sm:mb-0 flex flex-col md:flex-row justify-between  items-center pr-6">
                <div class="flex flex-col mt-3 md:mt-0 ">
                    <h2 class="text-lg text-gray-900 uppercase">{{job.name}}</h2>
                    <span class="text-sm mt-2">Posted On {{ format(job.created_at) }}</span>
                </div>
                <img class="w-24 h-24 rounded" :src="`${job.user.avatar}`" onerror="this.src='/css/placeholder.png'" />
            </div>
            <div class="mt-4">
                <div class="mb-4 flex items-center">
                    <h4 @click="tab='job';" class="font-sm  cursor-pointer" :class="{ 'border-b border-blue-500' : (tab === 'job') }">
                        Job Details
                    </h4>
                    <span v-if="job.user.is_employer" class="px-4">|</span>
                    <h4 v-if="job.user.is_employer" @click="tab='company';" class="font-sm cursor-pointer " :class="{ 'border-b border-blue-500' : (tab === 'company') }">Company
                    </h4>
                </div>
                <!-- Job Details -->
                <div v-if="tab === 'job'" class="flex flex-col">
                    <div class="flex flex-col mb-2">
                        <span class="text-lg mt-2">Apply Before : {{ format(job.apply_before) }}</span>
                    </div>
                    <div class="">
                        <p>
                            {{ job.description }}
                        </p>
                    </div>
                </div>
                <!-- Company Details -->
                <div v-if="job.user.is_employer">
                    <div v-if="tab === 'company'" class="flex flex-col">
                        <h4 class="text-lg">About</h4>
                        <p class="text-md mt-4">{{ job.user.name }}</p>
                        <p class="text-md mt-1">{{ job.user.email }}</p>
                        <p class="text-lg mt-4">{{ job.user.about }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { FormatDate } from '../Helpers/helpers.js';

export default {
    name: 'modal',
    props: {
        job: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            tab: 'job',
        }
    },
    methods: {
        format(date) {
            return FormatDate(date);
        },
        setTab(tab) {
            this.tab = tab;
        }
    }
};
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>