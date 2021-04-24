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
            <list
                :items="events"
                :filters="filters"
            >
                <list-filters :route="route('volunteer.events.index')">
                    <div class="my-6 flex">
                        <list-filter-search field="title" instant class="mr-4"/>
                        <list-filter-menu>
                            <list-filter-date field="start">
                                Event Start
                            </list-filter-date>
                            <list-filter-date field="end">
                                Event End
                            </list-filter-date>
                        </list-filter-menu>
                    </div>
                </list-filters>
                <list-items>
                    <template v-slot="{ item }">
                        <x-divider/>
                        <list-item :href="route('volunteer.events.show', { id: item.id })">
                            <div class="flex flex-row items-center justify-between">
                                <div>
                                    <x-text>
                                        {{ item.title }}
                                    </x-text>
                                    <x-label>
                                        {{ formatDate(item.start) }}
                                    </x-label>
                                </div>
                                <div>
                                    <chevron-right-icon class="h-5 w-5 text-gray-500"/>
                                </div>
                            </div>
                        </list-item>
                    </template>
                    <template #empty>
                        <x-divider/>
                        <x-subtitle class="text-center">
                            There are no events to show.
                        </x-subtitle>
                        <x-label class="text-center">
                            Make sure you haven't applied any filters by accident.
                        </x-label>
                    </template>
                </list-items>
                <x-divider/>
                <list-pagination/>
            </list>
        </x-card>
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
import List from "@/Components/List/List";
import ListItems from "@/Components/List/ListItems";
import ListItem from "@/Components/List/ListItem";
import ListFilters from "@/Components/List/ListFilters";
import ListFilterSearch from "@/Components/List/ListFilterSearch";
import ListPagination from "@/Components/List/ListPagination";
import ListFilterMenu from "@/Components/List/ListFilterMenu";
import ListFilterDate from "@/Components/List/ListFilterDate";
import ListFilterSelect from "@/Components/List/ListFilterSelect";
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
        List,
        ListItems,
        ListItem,
        ListFilters,
        ListFilterSearch,
        ListPagination,
        ListFilterMenu,
        ListFilterDate,
        ListFilterSelect,
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
}
</script>

<style scoped>

</style>
