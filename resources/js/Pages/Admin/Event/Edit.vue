<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <x-title>
                Edit an Event
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
                        <form-input
                            field="venue_name"
                            type="text"
                            placeholder=""
                            autocomplete="off"
                            required
                            disabled
                        >
                            Venue
                        </form-input>
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
                <button
                    type="submit"
                    class="mt-12 w-full py-3 px-6 text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow-sm disabled:bg-gray-500 disabled:cursor-wait"
                    :disabled="form.processing"
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
    name: 'Edit',
    components: {FormSelect, FormInput, XTitle, XCard, AdminLayout},
    props: {
        event: Object,
    },
    setup(props, context) {
        const route = inject('route');

        const breadcrumbs = ref([
            { name: 'Events', url: route('admin.events.index') },
            { name: 'Edit', url: window.location.pathname },
        ]);

        const getDate = (rawDate) => {
            let date = new Date(rawDate)
            let year = date.getFullYear();
            let month = `0${date.getMonth()+1}`.slice(-2);
            let day = `0${date.getDate()}`.slice(-2);
            return `${year}-${month}-${day}`;
        }

        const getTime = (rawDate) => {
            let date = new Date(rawDate)
            let hour = `0${date.getHours()}`.slice(-2);
            let minute = `0${date.getMinutes()}`.slice(-2);
            return `${hour}:${minute}`;
        }

        const form = useForm({
            title: props.event.title,
            start_date: getDate(props.event.start),
            start_time: getTime(props.event.start),
            end_date: getDate(props.event.end),
            end_time: getTime(props.event.end),
            venue_name: props.event.venue.name,
        })

        const submit = () => {
            form.put(route('admin.events.update', {id: props.event.id}))
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
