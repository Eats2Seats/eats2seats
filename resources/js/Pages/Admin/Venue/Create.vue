<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <h2 class="font-sans font-bold text-2xl text-gray-700">
                Add a Venue
            </h2>
            <hr class="my-6"/>
            <form
                @submit.prevent="submit"
                class=""
            >
                <div class="grid grid-cols-2 gap-8">
                    <form-input
                        field="name"
                        type="text"
                        placeholder="Kenan Memorial Stadium"
                        autocomplete="on"
                        required
                    >
                        Name
                    </form-input>
                    <form-input
                        field="street"
                        type="text"
                        placeholder="123 Tarheel Lane"
                        autocomplete="on"
                        required
                    >
                        Street
                    </form-input>
                    <form-input
                        field="city"
                        type="text"
                        placeholder="Chapel Hill"
                        autocomplete="on"
                        required
                    >
                        City
                    </form-input>
                    <form-input
                        field="state"
                        type="text"
                        placeholder="North Carolina"
                        autocomplete="on"
                        required
                    >
                        State
                    </form-input>
                    <form-input
                        field="zip"
                        type="text"
                        placeholder="27514"
                        autocomplete="on"
                        required
                    >
                        Zip
                    </form-input>
                </div>
                <button
                    type="submit"
                    class="mt-8 w-full py-3 px-6 text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow-sm disabled:bg-gray-500 disabled:cursor-wait"
                    :disabled="form.processing"
                >
                    Add Venue
                </button>
            </form>
        </x-card>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout";
import {inject, provide, ref} from "vue";
import XCard from "@/Components/General/XCard";
import {useForm} from "@inertiajs/inertia-vue3";
import FormInput from "@/Components/Form/FormInput";
export default {
    name: 'Create',
    components: {FormInput, XCard, AdminLayout},
    props: {},
    setup(props, context) {
        const route = inject('route');

        const breadcrumbs = ref([
            { name: 'Venues', url: route('admin.venues.index') },
            { name: 'Create', url: window.location.href },
        ]);

        const form = useForm({
            name: null,
            street: null,
            city: null,
            state: null,
            zip: null,
        })

        const submit = () => {
            form.post(route('admin.venues.store'))
        }

        provide('form', form);

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
