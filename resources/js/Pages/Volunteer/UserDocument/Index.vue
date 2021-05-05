<template>
    <div class="container mx-auto h-screen flex flex-col justify-center items-center">
        <div class="sm:w-[640px] flex flex-col">
            <document-submissions-card
                :latest="latest"
                :all="all"
            />
            <inertia-link
                v-if="latest?.review_status !== 'pending'"
                :href="route('volunteer.user-documents.create')"
                class="mt-4 mr-4 self-end font-normal font-sans text-indigo-600 text-base underline hover:text-indigo-700"
            >
                Upload new documents
            </inertia-link>
        </div>
        <h1 class="absolute bottom-0 mb-12 font-sans font-bold text-gray-300 text-3xl">
            Eats2Seats
        </h1>
    </div>
</template>

<script>

import UploadDocumentsCard from "@/Components/Pages/Volunteer/UserDocument/Index/UploadDocumentsCard";
import {inject} from "vue";
import DocumentSubmissionsCard from "@/Components/Pages/Volunteer/UserDocument/Index/DocumentSubmissionsCard";
export default {
    name: 'Index',
    components: {DocumentSubmissionsCard, UploadDocumentsCard},
    props: {
        latest: Object,
        all: Object,
    },
    setup(props, context) {
        // Inject Ziggy route helper
        const route = inject('route');

        return {};
    },
}
</script>

<style scoped>

</style>
