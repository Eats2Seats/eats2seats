<template>
    <div class="container mx-auto h-screen flex flex-col justify-center items-center">
        <div class="sm:w-[640px] flex flex-col">
            <upload-documents-card/>
            <inertia-link
                v-if="is_previous"
                :href="route('volunteer.user-documents.index')"
                class="mt-4 mr-4 self-end font-normal font-sans text-indigo-600 text-base underline hover:text-indigo-700"
            >
                View previous submissions
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

export default {
    name: 'Create',
    components: {UploadDocumentsCard},
    props: {
        is_previous: {
            type: Boolean,
            required: true,
        }
    },
    setup(props, context) {
        // Inject Ziggy route helper
        const route = inject('route');

        return {
            route,
        };
    },
}
</script>

<style scoped>

</style>
