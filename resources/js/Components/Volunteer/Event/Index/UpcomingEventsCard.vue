<template>
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
                        <list-filter-select field="venue_name">
                            Venue
                        </list-filter-select>
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
</template>

<script>
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XSubtitle from "@/Components/General/XSubtitle";
import XText from "@/Components/General/XText";
import XLabel from "@/Components/General/XLabel";
import XDivider from "@/Components/General/XDivider";
import List from "@/Components/List/List";
import ListItems from "@/Components/List/ListItems";
import ListItem from "@/Components/List/ListItem";
import ListFilters from "@/Components/List/ListFilters";
import ListFilterSearch from "@/Components/List/ListFilterSearch";
import ListFilterMenu from "@/Components/List/ListFilterMenu";
import ListFilterDate from "@/Components/List/ListFilterDate";
import ListPagination from "@/Components/List/ListPagination";
import {ChevronRightIcon} from "@heroicons/vue/outline";
import ListFilterSelect from "@/Components/List/ListFilterSelect";

export default {
    name: 'UpcomingEventsCard',
    components: {
        ListFilterSelect,
        XCard,
        XTitle,
        XSubtitle,
        XText,
        XLabel,
        XDivider,
        List,
        ListItems,
        ListItem,
        ListFilters,
        ListFilterSearch,
        ListFilterMenu,
        ListFilterDate,
        ListPagination,
        ChevronRightIcon,
    },
    props: {
        events: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            required: true,
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
    }
}
</script>

<style scoped>

</style>
