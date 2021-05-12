<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <x-title>
                Create an Event
            </x-title>
            <hr class="my-6"/>
            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-8">
                    <form-input
                        field="title"
                        type="text"
                        placeholder="UNC vs Duke"
                        autocomplete="on"
                        required
                    >
                        Title
                    </form-input>
                    <div class="flex flex-col">
                        <label
                            for="venue"
                            class="font-sans font-normal text-base text-gray-500"
                        >
                            Venue
                            <span class="text-red-600">*</span>
                        </label>
                        <select
                            v-model="form.venue"
                            id="venue"
                            name="venue"
                            class="mt-1"
                            @change="selectStands"
                        >
                            <option :value="null">
                                Choose One
                            </option>
                            <option
                                v-for="venue in venues"
                                :key="venue.name"
                                :value="venue.id"
                            >
                                {{ venue.name }}
                            </option>
                        </select>
                        <p
                            v-if="error"
                            class="mt-1 font-sans font-normal text-sm text-red-600"
                        >
                            {{ error }}
                        </p>
                    </div>
                    <form-input
                        field="start_date"
                        type="date"
                        placeholder=""
                        autocomplete="off"
                        required
                    >
                        Start Date
                    </form-input>
                    <form-input
                        field="start_time"
                        type="time"
                        placeholder=""
                        autocomplete="off"
                        required
                    >
                        Start Time
                    </form-input>
                    <form-input
                        field="end_date"
                        type="date"
                        placeholder=""
                        autocomplete="off"
                        required
                    >
                        End Date
                    </form-input>
                    <form-input
                        field="end_time"
                        type="time"
                        placeholder=""
                        autocomplete="off"
                        required
                    >
                        End Time
                    </form-input>
                </div>
                <div class="mt-12">
                    <h4 class="font-sans font-bold text-base text-gray-700 text-2xl">
                        Stands
                    </h4>
                    <hr class="my-6"/>
                    <span
                        v-if="form.stands.length === 0"
                        class="font-sans font-normal text-gray-500 text-center text-base"
                    >
                        Please select a venue to continue.
                    </span>
                    <div
                        v-else
                        class="w-full flex flex-row items-center space-x-8 mt-6"
                    >
                        <p class="w-1/5 font-sans font-bold text-gray-700 text-sm">
                            Location
                        </p>
                        <p class="w-2/5 font-sans font-bold text-gray-700 text-sm">
                            Name
                        </p>
                        <p class="w-2/5 font-sans font-bold text-gray-700 text-sm">
                            Available Positions
                        </p>
                    </div>
                    <div
                        class="w-full flex flex-row items-center space-x-8 mt-6"
                        v-for="(stand, index) in form.stands"
                        :key="stand"
                    >
                        <p class="w-1/5">
                            {{ form.stands[index].location }}
                        </p>
                        <input
                            class="w-2/5"
                            type="text"
                            v-model="form.stands[index].default_name"
                        />
                        <input
                            class="w-2/5"
                            type="text"
                            v-model="form.stands[index].default_positions"
                        />
                    </div>
                </div>
                <button
                    type="submit"
                    class="mt-12 w-full py-3 px-6 text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow-sm disabled:bg-gray-500"
                    :class="form.processing ? 'disabled:cursor-wait' : ''"
                    :disabled="form.processing || form.stands.length === 0"
                >
                    Add Event
                </button>
            </form>
        </x-card>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout";
import {inject, provide, ref} from "vue";
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import FormInput from "@/Components/Form/FormInput";
import {useForm} from "@inertiajs/inertia-vue3";
import FormSelect from "@/Components/Form/FormSelect";
export default {
    name: 'Create',
    components: {FormSelect, FormInput, XTitle, XCard, AdminLayout},
    props: {
        venues: Object,
    },
    setup(props, context) {
        const route = inject('route');

        const breadcrumbs = ref([
            { name: 'Events', url: route('admin.events.index') },
            { name: 'Create', url: window.location.pathname },
        ]);

        const form = useForm({
            title: null,
            start_date: null,
            start_time: null,
            end_date: null,
            end_time: null,
            venue: null,
            stands: [],
        })

        const submit = () => {
            form.post(route('admin.events.store'))
        }

        const selectStands = () => {
            let venue = props.venues.find(venue => venue.id === form.venue);
            form.venue
                ? form.stands = _.cloneDeep(venue.stands)
                : form.stands = [];
        };

        provide('form', form);

        return {
            route,
            breadcrumbs,
            form,
            submit,
            selectStands,
        };
    },
}
</script>

<style scoped>

</style>
