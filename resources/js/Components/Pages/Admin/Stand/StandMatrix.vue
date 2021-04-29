<template>
    <matrix
        :data="stands"
        :route="route('admin.stands.index')"
        v-slot="{ rowsSelected }"
    >
        <div class="flex flex-row justify-between items-center p-6 border-b border-gray-200">
            <h2 class="font-serif font-bold text-4xl text-gray-700">
                Stands
            </h2>
            <div class="flex flex-row items-center items-stretch space-x-4">
                <matrix-filter-search
                    field="location"
                    instant
                />
                <matrix-filter-menu
                    title="Filter Stands"
                    margin-adjustment="-ml-4"
                >
                    <matrix-filter-select field="venue_name">
                        Venue
                    </matrix-filter-select>
                    <matrix-filter-select field="default_name">
                        Default Name
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
                    :href="route('admin.stands.create')"
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
                <matrix-head-cell field="location">
                    Stand
                </matrix-head-cell>
                <matrix-head-cell field="venue_name">
                    Venue
                </matrix-head-cell>
                <matrix-head-cell field="default_name">
                    Default Name
                </matrix-head-cell>
                <matrix-head-cell>
                    <span class="sr-only">
                        Actions
                    </span>
                </matrix-head-cell>
            </matrix-head>
            <matrix-body v-slot="{ row }">
                <matrix-body-cell-select :id="row.id"/>
                <matrix-body-cell field="location">
                    {{ row.location }}
                </matrix-body-cell>
                <matrix-body-cell field="venue_name">
                    {{ row.venue_name }}
                </matrix-body-cell>
                <matrix-body-cell field="default_name">
                    {{ row.default_name }}
                </matrix-body-cell>
                <matrix-body-cell>
                    <div class="flex justify-end space-x-3">
                        <inertia-link
                            :href="route('admin.stands.show', { id: row.id })"
                            class="group"
                        >
                            <eye-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600"/>
                        </inertia-link>
                        <inertia-link
                            :href="route('admin.stands.edit', { id: row.id })"
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
                <matrix-column-visibility-item field="default_name">
                    Default Name
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
import {EyeIcon, PencilAltIcon} from "@heroicons/vue/outline";
import MatrixColumnVisibility from "@/Components/Matrix/MatrixColumnVisibility";
import MatrixColumnVisibilityItem from "@/Components/Matrix/MatrixColumnVisibilityItem";
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
import MatrixFilterSelect from "@/Components/Matrix/MatrixFilterSelect";
import MatrixRowAction from "@/Components/Matrix/MatrixRowAction";
import MatrixRowActionItem from "@/Components/Matrix/MatrixRowActionItem";
import {TrashIcon, PlusSmIcon} from "@heroicons/vue/solid";
export default {
    name: 'StandMatrix',
    components: {
        MatrixRowActionItem,
        MatrixRowAction,
        MatrixFilterSelect,
        MatrixFilterMenu,
        MatrixFilterSearch,
        MatrixPagination,
        MatrixColumnVisibilityItem,
        MatrixColumnVisibility,
        TrashIcon,
        PlusSmIcon,
        EyeIcon,
        PencilAltIcon,
        MatrixBodyCell,
        MatrixBodyCellSelect,
        MatrixBody,
        MatrixHeadCell,
        MatrixHeadCellSelect,
        MatrixHead,
        MatrixTable,
        Matrix
    },
    props: {
        stands: {
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
