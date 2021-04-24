<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <x-title>
                Next Event
            </x-title>
            <x-subtitle>
                View details for the next upcoming event with remaining staffing positions.
            </x-subtitle>
            <x-divider/>
            <x-label>
                Title
            </x-label>
            <x-text>
                {{ next.title }}
            </x-text>
            <x-divider/>
            <div class="flex flex-row items-center justify-between">
                <div>
                    <x-label>
                        Location
                    </x-label>
                    <x-text>
                        {{ next.venue.name }}
                    </x-text>
                </div>
                <div>
                    <a
                        :href="googleMapsLink"
                        target="_blank"
                    >
                        <x-icon-button>
                            <MapIcon class="h-6 w-6 text-gray-500"/>
                        </x-icon-button>
                    </a>
                </div>
            </div>
            <x-divider/>
            <x-label>
                Start
            </x-label>
            <x-text>
                {{ formatDate(next.start) }}
            </x-text>
            <x-divider/>
            <x-label>
                End
            </x-label>
            <x-text>
                {{ formatDate(next.end) }}
            </x-text>
            <x-divider/>
            <inertia-link :href= "'/volunteer/events/' + next.id" >
                <x-button>
                View More Details
                </x-button>
            </inertia-link>
        </x-card>
        <x-card>
            <x-title>
                Upcoming Events
            </x-title>
            <x-subtitle>
                View all future events with available staffing positions you can reserve.
            </x-subtitle>
            <div class="my-6 flex space-x-4">
                <div class="flex-1 relative rounded shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span>
                            <search-icon class="inline mr-2 h-4 w-4 text-gray-500"/>
                        </span>
                    </div>
                    <input
                        class="block w-full pl-10"
                        type="text"
                        placeholder="Search"
                        v-model="form.title"
                    >
                </div>
                <x-icon-button
                    class="px-4"
                    v-on:click="$refs.filterMenu.toggleMenu()"
                >
                    <filter-icon class="h-4 w-4 text-gray-500"/>
                </x-icon-button>
            </div>
            <div
                v-for="event in events.data"
                :key="event.id"
            >
                <x-divider/>
                <inertia-link :href= "'/volunteer/events/' + event.id" >
                    <div class="flex flex-row items-center justify-between">
                        <div>
                            <x-text>
                                {{ event.title }}
                            </x-text>
                            <x-label>
                                {{ formatDate(event.start) }}
                            </x-label>
                        </div>
                        <div>
                            <chevron-right-icon class="h-5 w-5 text-gray-500"/>
                        </div>
                    </div>
                </inertia-link>
            </div>
            <x-divider/>
            <x-pagination :list="events"/>
        </x-card>
        <x-slide-out-menu ref="filterMenu">
            <template #title>
                Filter Events
            </template>
            <template #body>
                <div class="flex flex-col space-y-4 px-6 mt-6">
                    <div class="flex flex-col">
                        <label
                            class="mb-1.5 font-serif font-normal text-sm text-gray-500"
                            for="filter-date-start"
                        >
                            Start Date
                        </label>
                        <input
                            type="date"
                            id="filter-date-start"
                            v-model="form.start"
                        >
                    </div>
                    <div class="flex flex-col">
                        <label
                            class="mb-1.5 font-serif font-normal text-sm text-gray-500"
                            for="filter-date-end"
                        >
                            End Date
                        </label>
                        <input
                            class=""
                            type="date"
                            id="filter-date-end"
                            v-model="form.end"
                        >
                    </div>
                </div>
            </template>
        </x-slide-out-menu>
    </volunteer-layout>
</template>

<script>
import throttle from 'lodash/throttle';
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import XCard from "@/Components/Card";
import XTitle from "@/Components/Title";
import XSubtitle from "@/Components/Subtitle";
import XLabel from "@/Components/Label";
import XText from "@/Components/Text";
import XDivider from "@/Components/Divider";
import XButton from "@/Components/Button";
import XIconButton from "@/Components/IconButton";
import XSlideOutMenu from "@/Components/SlideOutMenu";
import XPagination from "@/Components/Pagination";
import { MapIcon, SearchIcon } from "@heroicons/vue/outline";
import { ChevronRightIcon, FilterIcon } from "@heroicons/vue/solid";
import IconButton from "@/Components/IconButton";
export default {
    name: 'Index',
    components: {
        VolunteerLayout,
        XCard,
        XTitle,
        XSubtitle,
        XLabel,
        XText,
        XDivider,
        XButton,
        XIconButton,
        XSlideOutMenu,
        XPagination,
        MapIcon,
        ChevronRightIcon,
        SearchIcon,
        FilterIcon,
    },
    props: {
        next: Object,
        events: Array,
        filters: Object,
    },
    data () {
        return {
            breadcrumbs: [
                { name: 'Events', url: window.location.pathname },
            ],
            form: {
                title: this.filters.title,
                start: this.filters.start,
                end: this.filters.end,
            },
        }
    },
    computed: {
        googleMapsLink () {
            return `https://www.google.com/maps/place/${this.next.venue.street}+${this.next.venue.city}+${this.next.venue.state}+${this.next.venue.zip}`.split(' ').join('+');
        },
    },
    methods: {
        formatDate (rawDate) {
            let dateObj = new Date(rawDate);
            let dateStr = dateObj.toLocaleDateString('en-US', {
                day: 'numeric',
                weekday: 'short',
                month: 'long',
                ...(new Date().getFullYear() !== dateObj.getFullYear() && { year: 'numeric'}),
            });
            let timeStr = dateObj.toLocaleTimeString('en-US', {
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
            });
            return `${dateStr} @ ${timeStr}`;
        },
    },
    watch: {
        form: {
            handler: throttle(function () {
                this.$inertia.get(this.route('volunteer.events.index', Object.keys(this.form)
                    ? this.form
                    : { remember: 'forget' }
                ), this.form, {
                    preserveState: true,
                    preserveScroll: true,
                });
            }, 150),
            deep: true,
        }
    }

}
</script>

<style scoped>

</style>
