<template>
    <div class="absolute  bg-white left-0 right-0  mx-auto  max-w-3xl shadow-lg rounded-lg p-6 z-30 h-screen overflow-y-scroll">
        <div class="flex flex-col sm:flex-row items-center mb-2">
            <h2 class="text-lg text-gray-900 capitalize">{{ job.name }}</h2>
            <span class="text-md ml-3">Posted On {{ format(job.created_at) }}</span>
        </div>
        <div class="">
            <p>
                {{ job.description }}
            </p>
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
        return {}
    },
    methods: {
        format(date) {
            return FormatDate(date);
        }
    }
};
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>