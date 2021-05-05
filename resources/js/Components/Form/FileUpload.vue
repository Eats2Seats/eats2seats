<template>
    <div class="w-full">
        <label
            :for="name"
            class="px-6 py-3 flex justify-center items-center border border-gray-200 rounded shadow-sm hover:bg-gray-50 hover:cursor-pointer"
        >
            <slot>
                <folder-icon class="h-6 w-6 text-gray-500"/>
                <p class="pl-2 font-normal text-base text-gray-500">Select a file</p>
            </slot>
        </label>
        <input
            :id="name"
            :name="name"
            type="file"
            accept="application/pdf"
            class="hidden"
            @change="setField"
        />
        <p class="mt-1 font-normal font-sans text-sm text-gray-500 text-right truncate">
            {{ value ? value.name : 'None selected' }}
        </p>
    </div>
</template>

<script>
import {computed, inject, ref} from "vue";
import {FolderIcon} from "@heroicons/vue/outline/esm";

export default {
    name: 'FileUpload',
    components: {
        FolderIcon,
    },
    props: {
        field: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        }
    },
    setup(props, context) {
        // Inject form data
        const form = inject('form');

        // Define computed getter and setter for form field
        const value = computed({
            get: () => form[props.field],
            set: val => form[props.field] = val
        });

        // Define function for updating field on form object
        const setField = (event) => {
            value.value = event.target.files[0];
        }

        return {
            value,
            setField,
        };
    },
}
</script>

<style scoped>

</style>
