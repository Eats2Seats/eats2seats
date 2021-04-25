<template>
    <x-card>
        <x-title>
            My Reservations
        </x-title>
        <x-subtitle>
            View all past, present, and future events that you've committed to attending.
        </x-subtitle>
        <list
            :items="reservations"
            :filters="filters"
        >
            <list-filters :route="route('volunteer.reservations.index')">
                <div class="my-6 flex">
                    <list-filter-search field="event_title" instant class="mr-4"/>
                    <list-filter-menu>
                        <list-filter-date field="event_start">
                            Event Start
                        </list-filter-date>
                        <list-filter-date field="event_end">
                            Event End
                        </list-filter-date>
                        <list-filter-select field="venue_name">
                            Venue Name
                        </list-filter-select>
                        <list-filter-select field="position_type">
                            Position Type
                        </list-filter-select>
                    </list-filter-menu>
                </div>
            </list-filters>
            <list-items>
                <template v-slot="{ item }">
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
                </template>
                <template #empty>
                    <x-divider/>
                    <x-subtitle class="text-center">
                        There are no reservations to show.
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
import ListPagination from "@/Components/List/ListPagination";
import ListFilters from "@/Components/List/ListFilters";
import ListFilterMenu from "@/Components/List/ListFilterMenu";
import ListFilterSearch from "@/Components/List/ListFilterSearch";
import ListFilterDate from "@/Components/List/ListFilterDate";
import ListFilterSelect from "@/Components/List/ListFilterSelect";
import {ChevronRightIcon} from "@heroicons/vue/outline";

export default {
    name: 'UpcomingReservationsCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XText,
        XLabel,
        XDivider,
        List,
        ListItems,
        ListItem,
        ListPagination,
        ListFilters,
        ListFilterMenu,
        ListFilterSearch,
        ListFilterDate,
        ListFilterSelect,
        ChevronRightIcon,
    },
    props: {
        reservations: {
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
    },
}
</script>

<style scoped>

</style>
