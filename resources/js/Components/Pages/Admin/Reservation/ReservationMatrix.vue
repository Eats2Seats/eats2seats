<template>
    <matrix
        :data="reservations"
        :route="route('admin.reservations.index')"
        v-slot="{ rowsSelected }"
    >
        <div class="flex flex-row justify-between items-center p-6 border-b border-gray-200">
            <h2 class="font-serif font-bold text-4xl text-gray-700">
                Reservations
            </h2>
            <div class="flex flex-row items-center items-stretch space-x-4">
                <matrix-filter-menu title="Filter Reservations">
                    <matrix-filter-select field="event_title">
                        Event
                    </matrix-filter-select>
                    <matrix-filter-select field="venue_name">
                        Venue
                    </matrix-filter-select>
                    <matrix-filter-select field="stand_location">
                        Location
                    </matrix-filter-select>
                    <matrix-filter-select field="user_first_name">
                        First Name
                    </matrix-filter-select>
                    <matrix-filter-select field="user_last_name">
                        Last Name
                    </matrix-filter-select>
                    <matrix-filter-select field="stand_name">
                        Stand
                    </matrix-filter-select>
                    <matrix-filter-select field="position_type">
                        Position Type
                    </matrix-filter-select>
                </matrix-filter-menu>
                <matrix-row-action
                    v-if="rowsSelected"
                    v-slot="{ executeAction }"
                >
                    <matrix-row-action-item @click="executeAction()">
                        <div class="flex items-center space-x-3">
                            <trash-icon class="h-5 w-5 text-gray-500"/>
                            <p class="font-serif font-normal text-base text-gray-700">
                                Delete
                            </p>
                        </div>
                    </matrix-row-action-item>
                </matrix-row-action>
            </div>
        </div>
        <matrix-table>
            <matrix-head>
                <matrix-head-cell-select/>
                <matrix-head-cell field="event_title">
                    Event
                </matrix-head-cell>
                <matrix-head-cell field="venue_name">
                    Venue
                </matrix-head-cell>
                <matrix-head-cell field="stand_location">
                    Location
                </matrix-head-cell>
                <matrix-head-cell field="user_first_name">
                    First Name
                </matrix-head-cell>
                <matrix-head-cell field="user_last_name">
                    Last Name
                </matrix-head-cell>
                <matrix-head-cell field="stand_name">
                    Stand
                </matrix-head-cell>
                <matrix-head-cell field="position_type">
                    Position Type
                </matrix-head-cell>
                <matrix-head-cell>
                    <span class="sr-only">Actions</span>
                </matrix-head-cell>
            </matrix-head>
            <matrix-body v-slot="{ row }">
                <matrix-body-cell-select :id="row.id"/>
                <matrix-body-cell field="event_title">
                    {{ row.event_title }}
                </matrix-body-cell>
                <matrix-body-cell field="venue_name">
                    {{ row.venue_name }}
                </matrix-body-cell>
                <matrix-body-cell field="stand_location">
                    {{ row.stand_location }}
                </matrix-body-cell>
                <matrix-body-cell field="user_first_name">
                    {{ row.user_first_name ? row.user_first_name : '-----' }}
                </matrix-body-cell>
                <matrix-body-cell field="user_last_name">
                    {{ row.user_last_name ? row.user_last_name : '-----' }}
                </matrix-body-cell>
                <matrix-body-cell field="stand_name">
                    {{ row.stand_name }}
                </matrix-body-cell>
                <matrix-body-cell field="position_type">
                    {{ row.position_type }}
                </matrix-body-cell>
                <matrix-body-cell>
                    Actions
                </matrix-body-cell>
            </matrix-body>
        </matrix-table>
        <div class="flex flex-row items-center items-stretch p-6 space-x-4 border-t border-gray-200">
            <matrix-column-visibility>
                <matrix-column-visibility-item field="event_title">
                    Event
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="venue_name">
                    Venue
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="stand_location">
                    Location
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="user_first_name">
                    First Name
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="user_last_name">
                    Last Name
                </matrix-column-visibility-item>
            </matrix-column-visibility>
            <matrix-pagination/>
        </div>
    </matrix>
</template>

<script>
import Matrix from "@/Components/Matrix/Matrix";
import {inject} from "vue";
import MatrixTable from "@/Components/Matrix/MatrixTable";
import MatrixHead from "@/Components/Matrix/MatrixHead";
import MatrixHeadCellSelect from "@/Components/Matrix/MatrixHeadCellSelect";
import MatrixHeadCell from "@/Components/Matrix/MatrixHeadCell";
import MatrixBody from "@/Components/Matrix/MatrixBody";
import MatrixBodyCellSelect from "@/Components/Matrix/MatrixBodyCellSelect";
import MatrixBodyCell from "@/Components/Matrix/MatrixBodyCell";
import MatrixColumnVisibility from "@/Components/Matrix/MatrixColumnVisibility";
import MatrixColumnVisibilityItem from "@/Components/Matrix/MatrixColumnVisibilityItem";
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
import MatrixFilterSelect from "@/Components/Matrix/MatrixFilterSelect";
import MatrixRowAction from "@/Components/Matrix/MatrixRowAction";
import MatrixRowActionItem from "@/Components/Matrix/MatrixRowActionItem";
import {TrashIcon} from "@heroicons/vue/outline";
export default {
    name: 'ReservationMatrix',
    components: {
        TrashIcon,
        MatrixRowActionItem,
        MatrixRowAction,
        MatrixFilterSelect,
        MatrixFilterMenu,
        MatrixFilterSearch,
        MatrixPagination,
        MatrixColumnVisibilityItem,
        MatrixColumnVisibility,
        MatrixBodyCell,
        MatrixBodyCellSelect, MatrixBody, MatrixHeadCell, MatrixHeadCellSelect, MatrixHead, MatrixTable, Matrix},
    props: {
        reservations: {
            type: Object,
            required: true,
        },
    },
    setup(props, context) {
        // Inject Ziggy route helper
        const route = inject('route');

        return {
            route
        };
    },
}
</script>

<style scoped>

</style>
