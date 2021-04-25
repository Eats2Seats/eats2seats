<template>
    <x-card>
        <x-title>
            Positions
        </x-title>
        <x-subtitle>
            View all staffing positions that are available to reserve.
        </x-subtitle>
        <x-divider/>
        <x-subtitle class="!font-bold !mt-0">
            Position Options
        </x-subtitle>
        <x-divider/>
        <list :items="positions" :filters="filters">
            <list-filters :route="route('volunteer.events.show', { id: event.id })">
                <list-filter-select field="affiliation" instant>
                    Affiliation
                </list-filter-select>
                <list-filter-select field="position_type" instant class="mt-3 md:mt-4">
                    Position Type
                </list-filter-select>
            </list-filters>
            <x-divider/>
            <x-subtitle class="!font-bold !mt-0">
                Available Positions
            </x-subtitle>
            <list-items>
                <template v-slot="{ item }">
                    <x-divider/>
                    <list-item :href="route('volunteer.reservations.claim', {
                            event: item.event_id,
                            stand: item.stand_id,
                            positionType: item.position_type,
                        })">
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <x-text>
                                    {{ item.stand_name }}
                                </x-text>
                                <x-label>
                                    {{ item.position_type }}, {{ item.remaining }} {{ item.remaining === 1 ? 'position' : 'positions' }} remaining
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
                        There are no available positions to show.
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
import ListFilterSelect from "@/Components/List/ListFilterSelect";
import ListPagination from "@/Components/List/ListPagination";
import {ChevronRightIcon} from "@heroicons/vue/outline";

export default {
    name: 'AvailablePositionsCard',
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
        ListFilters,
        ListFilterSearch,
        ListFilterMenu,
        ListFilterDate,
        ListFilterSelect,
        ListPagination,
        ChevronRightIcon,
    },
    props: {
        event: {
            type: Object,
            required: true,
        },
        positions: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
