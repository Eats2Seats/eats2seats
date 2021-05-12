<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <h2 class="font-sans font-bold text-2xl text-gray-700">
                Edit a Venue
            </h2>
            <hr class="my-6"/>
            <form
                @submit.prevent="submit"
                class=""
            >
                <div class="grid grid-cols-2 gap-8">
                    <form-select
                        field="venue_id"
                        required
                    >
                        Venue
                    </form-select>
                    <form-input
                        field="default_name"
                        type="text"
                        placeholder="Carrie's Cotton Candy"
                        autocomplete="on"
                        required
                    >
                        Default Name
                    </form-input>
                    <form-input
                        field="location"
                        type="text"
                        placeholder="Stand #99"
                        autocomplete="on"
                        required
                    >
                        Location
                    </form-input>
                </div>
                <button
                    type="submit"
                    class="mt-8 w-full py-3 px-6 text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow-sm disabled:bg-gray-500 disabled:cursor-wait"
                    :disabled="form.processing"
                >
                    Edit Venue
                </button>
            </form>
        </x-card>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout";
import XCard from "@/Components/General/XCard";
import FormInput from "@/Components/Form/FormInput";
import FormSelect from "@/Components/Form/FormSelect";
import {inject, provide, ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";
export default {
    name: 'Edit',
    components: {FormSelect, FormInput, XCard, AdminLayout},
    props: {
        id: Number,
        default_name: String,
        location: String,
        venue_id: Number,
        options: Object,
    },
    setup(props, context) {
        const route = inject('route');

        const breadcrumbs = ref([
            { name: 'Stands', url: route('admin.stands.index') },
            { name: 'Edit', url: window.location.href },
        ]);

        const form = useForm({
            venue_id: props.venue_id,
            default_name: props.default_name,
            location: props.location,
        });

        const submit = () => {
            form.put(route('admin.stands.update', {id: props.id}))
        }

        provide('form', form);
        provide('form-options', props.options);

        return {
            route,
            breadcrumbs,
            form,
            submit,
        };
    },
}
</script>

<style scoped>

</style>
