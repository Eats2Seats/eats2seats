<template>
    <matrix
        :data="venues"
        :route="route('admin.venues.index')"
        v-slot="{ rowsSelected }"
    >
        <div class="flex flex-row justify-between items-center p-6 border-b border-gray-200">
            <h2 class="font-serif font-bold text-4xl text-gray-700">
                Venues
            </h2>
            <div class="flex flex-row items-center items-stretch space-x-4">
                <matrix-filter-search
                    field="name"
                    instant
                />
                <matrix-filter-menu
                    title="Filter Events"
                    margin-adjustment="-ml-4"
                >
                    <matrix-filter-select field="city">
                        City
                    </matrix-filter-select>
                    <matrix-filter-select field="state">
                        State
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
                <inertia-link
                    v-else
                    :href="route('admin.venues.create')"
                    class="inline-flex justify-center items-center space-x-2 rounded-md border border-gray-200 px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 shadow-sm"
                >
                    <p class="font-serif font-bold text-sm text-gray-700 leading-none">
                        Create
                    </p>
                    <plus-sm-icon class="h-5 w-5 text-gray-500"/>
                </inertia-link>
            </div>
        </div>
        <matrix-table>
            <matrix-head>
                <matrix-head-cell-select/>
                <matrix-head-cell field="name">
                    Name
                </matrix-head-cell>
                <matrix-head-cell field="street">
                    Street
                </matrix-head-cell>
                <matrix-head-cell field="city">
                    City
                </matrix-head-cell>
                <matrix-head-cell field="state">
                    State
                </matrix-head-cell>
                <matrix-head-cell field="zip">
                    Zip
                </matrix-head-cell>
                <matrix-head-cell field="events_count">
                    Events
                </matrix-head-cell>
                <matrix-head-cell field="stands_count">
                    Stands
                </matrix-head-cell>
                <matrix-head-cell>
                    <span class="sr-only">Actions</span>
                </matrix-head-cell>
            </matrix-head>
            <matrix-body v-slot="{ row }">
                <matrix-body-cell-select :id="row.id"/>
                <matrix-body-cell field="name">
                    {{ row.name }}
                </matrix-body-cell>
                <matrix-body-cell field="street">
                    {{ row.street }}
                </matrix-body-cell>
                <matrix-body-cell field="city">
                    {{ row.city }}
                </matrix-body-cell>
                <matrix-body-cell field="state">
                    {{ row.state }}
                </matrix-body-cell>
                <matrix-body-cell field="zip">
                    {{ row.zip }}
                </matrix-body-cell>
                <matrix-body-cell field="events_count">
                    <inertia-link
                        :href="route('admin.events.index') + '?events[filter][venue_name]=' + row.name"
                        class="underline"
                    >
                        {{ row.events_count }}
                    </inertia-link>
                </matrix-body-cell>
                <matrix-body-cell field="stands_count">
                    <inertia-link
                        :href="route('admin.stands.index') + '?events[filter][venue_name]=' + row.name"
                        class="underline"
                    >
                        {{ row.stands_count }}
                    </inertia-link>
                </matrix-body-cell>
                <matrix-body-cell>
                    <div class="flex justify-end space-x-3">
                        <inertia-link
                            :href="route('admin.venues.show', { id: row.id })"
                            class="group"
                        >
                            <eye-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600"/>
                        </inertia-link>
                        <inertia-link
                            :href="route('admin.venues.edit', { id: row.id })"
                            class="group"
                        >
                            <pencil-alt-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600"/>
                        </inertia-link>
                    </div>
                </matrix-body-cell>
            </matrix-body>
        </matrix-table>
        <div class="flex flex-row items-center items-stretch p-6 space-x-4 border-t border-gray-200">
            <matrix-column-visibility>
                <matrix-column-visibility-item field="street">
                    Street
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="city">
                    City
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="state">
                    State
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="zip">
                    Zip
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="events_count">
                    Events
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="stands_count">
                    Stands
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
import MatrixBody from "@/Components/Matrix/MatrixBody";
import MatrixHeadCellSelect from "@/Components/Matrix/MatrixHeadCellSelect";
import MatrixHeadCell from "@/Components/Matrix/MatrixHeadCell";
import MatrixBodyCellSelect from "@/Components/Matrix/MatrixBodyCellSelect";
import MatrixBodyCell from "@/Components/Matrix/MatrixBodyCell";
import {EyeIcon, PencilAltIcon} from "@heroicons/vue/outline";
import MatrixFilterSelect from "@/Components/Matrix/MatrixFilterSelect";
import MatrixFilterDate from "@/Components/Matrix/MatrixFilterDate";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixRowActionItem from "@/Components/Matrix/MatrixRowActionItem";
import MatrixRowAction from "@/Components/Matrix/MatrixRowAction";
import {PlusSmIcon, TrashIcon} from "@heroicons/vue/solid";
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
import MatrixColumnVisibilityItem from "@/Components/Matrix/MatrixColumnVisibilityItem";
import MatrixColumnVisibility from "@/Components/Matrix/MatrixColumnVisibility";
export default {
    name: 'VenueMatrix',
    components: {
        MatrixColumnVisibility,
        MatrixColumnVisibilityItem,
        MatrixPagination,
        MatrixRowAction,
        MatrixRowActionItem,
        MatrixFilterSearch,
        MatrixFilterMenu,
        MatrixFilterDate,
        MatrixFilterSelect,
        PlusSmIcon,
        TrashIcon,
        EyeIcon,
        PencilAltIcon,
        MatrixBodyCell,
        MatrixBodyCellSelect,
        MatrixHeadCell,
        MatrixHeadCellSelect,
        MatrixBody,
        MatrixHead,
        MatrixTable,
        Matrix
    },
    props: {
        venues: {
            type: Object,
            required: true,
        }
    },
    setup(props, context) {
        // Inject Ziggy route helper
        const route = inject('route');

        return {
            route,
        };
    },
}
</script>

<style scoped>

</style>
