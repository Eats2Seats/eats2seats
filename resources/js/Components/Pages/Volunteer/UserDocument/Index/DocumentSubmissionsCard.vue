<template>
    <div class="w-full flex flex-col divide-y divide-gray-200 bg-white rounded p-8 shadow-lg">
        <div class="mb-6 flex flex-col">
            <x-title>
                Legal Documents
            </x-title>
            <x-subtitle class="!text-gray-700">
                Your documents are pending review.
            </x-subtitle>
            <x-text
                v-if="latest.review_status === 'pending'"
                class="mt-4"
            >
                Your documents were received and are pending review by an administrator. Once they have been reviewed, you will receive an email with further instructions.
            </x-text>
            <x-text
                v-if="latest.review_status === 'rejected'"
                class="mt-4"
            >
                Your documents were reviewed by an administrator and marked as rejected. Please consult the provided reason below and upload your corrected documents for review.
            </x-text>
        </div>
        <div class="pt-6 w-full flex flex-col space-y-6 sm:flex-row sm:space-y-0 sm:space-x-8">
            <div class="w-full flex flex-col items-stretch">
                <div class="flex flex-col space-y-2">
                    <p class="font-normal font-sans text-base text-gray-500">
                        Latest Submission
                    </p>
                    <p class="font-sans font-normal text-gray-700 text-base capitalize">
                        <span class="font-bold">Status:</span> {{ latest.review_status }}
                    </p>
                    <p
                        v-if="latest?.review_message && latest.review_status !== 'pending'"
                        class="font-sans font-normal text-gray-700 text-base"
                    >
                        <span class="font-bold">Reason:</span> {{ latest.review_message }}
                    </p>
                    <p
                        v-if="latest?.reviewed_at && latest.review_status !== 'pending'"
                        class="font-sans font-normal text-gray-700 text-base"
                    >
                        <span class="font-bold">Reviewed on:</span> {{ latest.reviewed_at }}
                    </p>
                    <a
                        :href="route('volunteer.user-documents.download', {
                            id: latest.id,
                            file: 'liability',
                        })"
                        target="_blank"
                        class="font-normal font-sans text-indigo-600 text-base underline hover:text-indigo-700 hover:cursor-pointer"
                    >
                        View your liability waiver
                    </a>
                    <a
                        :href="route('volunteer.user-documents.download', {
                            id: latest.id,
                            file: 'tax',
                        })"
                        target="_blank"
                        class="font-normal font-sans text-indigo-600 text-base underline hover:text-indigo-700 hover:cursor-pointer"
                    >
                        View your W-9 tax form
                    </a>
                </div>
            </div>
            <div class="w-full">
                <div
                    class="flex flex-col h-full max-h-[10rem] overflow-y-auto"
                >
                    <p class="font-normal font-sans text-base text-gray-500">
                        All Submissions
                    </p>
                    <div
                        v-for="submission in all"
                        :key="submission.id"
                        class="mt-2 flex flex-row items-center space-x-4"
                    >
                        <div v-if="submission.review_status === 'pending'">
                            <question-mark-circle-icon class="h-5 w-5 text-yellow-600"/>
                            <span class="sr-only">Pending</span>
                        </div>
                        <div v-if="submission.review_status === 'approved'">
                            <check-circle-icon class="h-5 w-5 text-green-600"/>
                            <span class="sr-only">Approved</span>
                        </div>
                        <div v-if="submission.review_status === 'rejected'">
                            <x-circle-icon class="h-5 w-5 text-red-600"/>
                            <span class="sr-only">Rejected</span>
                        </div>
                        <p class="font-normal font-sans text-gray-700 text-base">
                            {{ submission.created_at }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import XIconButton from "@/Components/General/XIconButton";
import FileUpload from "@/Components/Form/FileUpload";
import XDivider from "@/Components/General/XDivider";
import XSubtitle from "@/Components/General/XSubtitle";
import XText from "@/Components/General/XText";
import XTitle from "@/Components/General/XTitle";
import XCard from "@/Components/General/XCard";
import {useForm} from "@inertiajs/inertia-vue3";
import {inject, provide} from "vue";
import {CheckCircleIcon, XCircleIcon, QuestionMarkCircleIcon} from "@heroicons/vue/solid/index";

export default {
    name: 'DocumentSubmissionCard',
    components: {
        XIconButton, FileUpload, XDivider, XSubtitle, XText, XTitle, XCard, CheckCircleIcon, XCircleIcon,
        QuestionMarkCircleIcon,
    },
    props: {
        latest: {
            type: Object,
            required: true,
        },
        all: {
            type: Object,
            required: true,
        }
    },
    setup(props, context) {
        // Inject Ziggy route helper
        const route = inject('route');

        // Define form object with Inertia form helper
        const form = useForm({
            liability_file: null,
            tax_file: null,
        });

        const submit = () => {
            form.post(route('volunteer.user-documents.store'), {
                preserveState: true,
                preserveScroll: true,
            });
            console.log(form.errors);
        }

        // Provide the form data to children components
        provide('form', form);

        return {
            route,
            form,
            submit
        };
    },
}
</script>

<style scoped>

</style>
