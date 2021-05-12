<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <x-title>
                {{ event.title }}
            </x-title>
            <hr class="my-6"/>
            <div class="w-full flex flex-row space-x-12">
                <div class="flex flex-col">
                    <x-label>
                        Start
                    </x-label>
                    <x-text>
                        {{ event.start }}
                    </x-text>
                </div>
                <div class="flex flex-col">
                    <x-label>
                        End
                    </x-label>
                    <x-text>
                        {{ event.end }}
                    </x-text>
                </div>
                <div class="flex flex-col">
                    <x-label>
                        Published
                    </x-label>
                    <x-text>
                        {{ event.published_at }}
                    </x-text>
                </div>
            </div>
        </x-card>
        <x-card>
            <x-title class="text-xl">
                Venue Details
            </x-title>
            <hr class="my-6"/>
            <div class="w-full flex flex-row space-x-12">
                <div class="flex flex-col">
                    <x-label>
                        Name
                    </x-label>
                    <x-text>
                        {{ event.venue.name }}
                    </x-text>
                </div>
                <div class="flex flex-col">
                    <x-label>
                        Street
                    </x-label>
                    <x-text>
                        {{ event.venue.street }}
                    </x-text>
                </div>
                <div class="flex flex-col">
                    <x-label>
                        City
                    </x-label>
                    <x-text>
                        {{ event.venue.city }}
                    </x-text>
                </div>
                <div class="flex flex-col">
                    <x-label>
                        State
                    </x-label>
                    <x-text>
                        {{ event.venue.state }}
                    </x-text>
                </div>
                <div class="flex flex-col">
                    <x-label>
                        Zip
                    </x-label>
                    <x-text>
                        {{ event.venue.zip }}
                    </x-text>
                </div>
            </div>
        </x-card>
        <event-stands-matrix
            :event="event.id"
            :stands="stands"
        />
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout";
import {inject, ref} from "vue";
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XLabel from "@/Components/General/XLabel";
import XText from "@/Components/General/XText";
import XSubtitle from "@/Components/General/XSubtitle";
import EventStandsMatrix from "@/Components/Pages/Admin/Event/Show/EventStandsMatrix";
export default {
    name: 'Show',
    components: {EventStandsMatrix, XSubtitle, XText, XLabel, XTitle, XCard, AdminLayout},
    props: {
        event: Object,
        stands: Object,
    },
    setup(props, context) {
        const route = inject('route');

        const breadcrumbs = ref([
            { name: 'Events', url: route('admin.events.index') },
            { name: 'View', url: window.location.pathname },
        ]);

        return {
            route,
            breadcrumbs,

        };
    },
}
</script>

<style scoped>

</style>
