<template>
    <div class="w-full flex flex-col divide-y divide-gray-200 bg-white rounded p-8 shadow-lg">
        <div class="mb-6 flex flex-col justify-between">
            <div class="">
                <x-title>
                    Legal Documents
                </x-title>
                <x-subtitle class="!text-gray-700">
                    Fill and sign the requested forms.
                </x-subtitle>
                <x-text class="mt-4">
                    Before you can sign up for events, you must fill and sign the provided liability waiver and W-9 tax form.
                </x-text>
            </div>
            <div class="flex flex-col mt-4 space-y-4">
                <a
                    href="#"
                    class="font-normal font-sans text-indigo-600 text-base underline hover:text-indigo-700"
                >
                    Download the liability waiver
                </a>
                <a
                    href="#"
                    class="font-normal font-sans text-indigo-600 text-base underline hover:text-indigo-700"
                >
                    Download the W-9 tax form
                </a>
            </div>
        </div>
        <form @submit.prevent class="flex flex-col">
            <div class="mt-6 w-full flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-8">
                <div class="w-full flex flex-col items-stretch">
                    <p class="font-normal font-sans text-base text-gray-500">
                        Liability Waiver
                    </p>
                    <file-upload
                        name="liability"
                        field="liability_file"
                        class="mt-1"
                    />
                </div>
                <div class="w-full flex flex-col items-stretch">
                    <p class="font-normal font-sans text-base text-gray-500">
                        W-9 Tax Form
                    </p>
                    <file-upload
                        name="tax"
                        field="tax_file"
                        class="mt-1"
                    />
                </div>
            </div>
            <button
                type="submit"
                class="w-full mt-6 px-6 py-3 flex justify-center items-center rounded shadow-sm bg-indigo-600 hover:bg-indigo-700 hover:cursor-pointer disabled:bg-gray-500"
                @click="submit"
                :disabled="form.processing"
            >
                    <span class="text-white">
                        Submit Documents
                    </span>
            </button>
        </form>
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

export default {
    name: 'UploadFilesCard',
    components: {XIconButton, FileUpload, XDivider, XSubtitle, XText, XTitle, XCard},
    props: {},
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
            form,
            submit
        };
    },
}
</script>

<style scoped>

</style>
