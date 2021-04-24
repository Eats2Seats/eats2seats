<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
<!--        <next-reservation :next="next"/>-->
        <x-card>
            <x-title>My Reservations</x-title>
            <x-subtitle>View all past, present, and future events that you've committed to attending.</x-subtitle>
            <list
                :items="reservations"
                :filters="filters"
            >
                <list-filters v-slot="{ fields }">
                    <div class="my-6 flex">
                        <list-filter-search
                            :fields="fields"
                            field="event_title"
                            class="mr-4"
                        />
                        <list-filter-menu>
                            <list-filter-date
                                :fields="fields"
                                field="event_start"
                            >
                                Event Start
                            </list-filter-date>
                            <list-filter-date
                                :fields="fields"
                                field="event_end"
                            >
                                Event End
                            </list-filter-date>
                            <list-filter-select
                                :fields="fields"
                                field="venue_name"
                                :options="filters.options"
                            >
                                Venue Name
                            </list-filter-select>
                            <list-filter-select
                                :fields="fields"
                                field="position_type"
                                :options="filters.options"
                            >
                                Position Type
                            </list-filter-select>
                        </list-filter-menu>
                    </div>
                </list-filters>
                <list-items v-slot="{ item }">
                    <x-divider/>
                    <list-item :href="route('volunteer.reservations.show', { id: item.id })">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <x-text>
                                    {{ item.event_title }}
                                </x-text>
                                <x-label>
                                    {{ formatDate(item.event_start) }}
                                </x-label>
                            </div>
                            <div>
                                <chevron-right-icon class="h-5 w-5 text-gray-500"/>
                            </div>
                        </div>
                    </list-item>
                </list-items>
                <x-divider/>
                <list-pagination/>
            </list>
        </x-card>
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import NextReservation from "@/Components/NextReservationCard"
import ReservationList from "@/Components/ReservationList"
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
import { SearchIcon } from "@heroicons/vue/outline";
import { ChevronRightIcon, FilterIcon } from "@heroicons/vue/solid";
import { throttle } from "lodash";
import Card from "@/Components/Card";
export default {
    name: 'Index',
    components: {
        Card,
        VolunteerLayout,
        NextReservation,
        ReservationList,
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
        reservations: Object,
        filters: Object,
    },
    data () {
        return {
            breadcrumbs: [
                { name: 'Reservations', url: window.location.pathname },
            ],
        }
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
        }
    },
}
</script>

<style scoped>

</style>
