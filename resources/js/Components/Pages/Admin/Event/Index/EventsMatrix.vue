<template>
    <matrix
        :data="events"
        :route="route('admin.events.index')"
        class="shadow"
        v-slot="{ rowsSelected }"
    >
        <div class="flex flex-row justify-between items-center p-6 border-b border-gray-200">
            <h2 class="font-serif font-bold text-4xl text-gray-700">
                Events
            </h2>
            <div class="flex flex-row items-center items-stretch space-x-4">
                <matrix-filter-search
                    field="title"
                    instant
                />
                <matrix-filter-menu
                    title="Filter Events"
                    margin-adjustment="-ml-4"
                >
                    <matrix-filter-date field="start">
                        Start
                    </matrix-filter-date>
                    <matrix-filter-date field="end">
                        End
                    </matrix-filter-date>
                    <matrix-filter-date field="published_at">
                        Published On
                    </matrix-filter-date>
                    <matrix-filter-select field="is_published">
                        Published
                    </matrix-filter-select>
                    <matrix-filter-select field="venue_name">
                        Venue
                    </matrix-filter-select>
                    <matrix-filter-select field="venue_state">
                        State
                    </matrix-filter-select>
                    <matrix-filter-select field="venue_city">
                        City
                    </matrix-filter-select>
                </matrix-filter-menu>
                <matrix-row-action
                    v-if="rowsSelected"
                    v-slot="{ executeAction }"
                >
                    <matrix-row-action-item @click="executeAction()">
                        <div class="flex items-center space-x-3">
                            <eye-icon-solid class="h-5 w-5 text-gray-500"/>
                            <p class="font-serif font-normal text-base text-gray-700">
                                Publish
                            </p>
                        </div>
                    </matrix-row-action-item>
                    <matrix-row-action-item @click="executeAction()">
                        <div class="flex items-center space-x-3">
                            <eye-off-icon class="h-5 w-5 text-gray-500"/>
                            <p class="font-serif font-normal text-base text-gray-700">
                                Unpublish
                            </p>
                        </div>
                    </matrix-row-action-item>
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
                    :href="route('admin.events.create')"
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
                <matrix-head-cell field="title">
                    Title
                </matrix-head-cell>
                <matrix-head-cell field="start">
                    Start
                </matrix-head-cell>
                <matrix-head-cell field="end">
                    End
                </matrix-head-cell>
                <matrix-head-cell field="is_published">
                    Published
                </matrix-head-cell>
                <matrix-head-cell field="published_at">
                    Published On
                </matrix-head-cell>
                <matrix-head-cell field="venue_name">
                    Venue
                </matrix-head-cell>
                <matrix-head-cell field="venue_state">
                    State
                </matrix-head-cell>
                <matrix-head-cell field="venue_city">
                    City
                </matrix-head-cell>
                <matrix-head-cell>
                    <span class="sr-only">
                        Actions
                    </span>
                </matrix-head-cell>
            </matrix-head>
            <matrix-body v-slot="{ row }">
                <matrix-body-cell-select :id="row.id"/>
                <matrix-body-cell field="title">
                    {{ row.title }}
                </matrix-body-cell>
                <matrix-body-cell field="start">
                    {{ formatDate(row.start) }}
                </matrix-body-cell>
                <matrix-body-cell field="end">
                    {{ formatDate(row.end) }}
                </matrix-body-cell>
                <matrix-body-cell field="is_published">
                    <check-circle-icon
                        v-if="row.is_published"
                        class="h-5 w-5 text-green-600"
                    />
                    <x-circle-icon
                        v-else
                        class="h-5 w-5 text-red-600"
                    />
                </matrix-body-cell>
                <matrix-body-cell field="published_at">
                    {{ formatDate(row.published_at) }}
                </matrix-body-cell>
                <matrix-body-cell field="venue_name">
                    <inertia-link
                        :href="route('admin.venues.show', { id: row.venue_id })"
                        class="underline"
                    >
                        {{ row.venue_name }}
                    </inertia-link>
                </matrix-body-cell>
                <matrix-body-cell field="venue_state">
                    {{ row.venue_state }}
                </matrix-body-cell>
                <matrix-body-cell field="venue_city">
                    {{ row.venue_city }}
                </matrix-body-cell>
                <matrix-body-cell>
                    <div class="flex justify-end space-x-3">
                        <inertia-link
                            :href="route('admin.events.show', { id: row.id })"
                            class="group"
                        >
                            <eye-icon-outline class="h-6 w-6 text-gray-500 group-hover:text-indigo-600"/>
                        </inertia-link>
                        <inertia-link
                            :href="route('admin.events.edit', { id: row.id })"
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
                <matrix-column-visibility-item field="start">
                    Start
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="end">
                    End
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="is_published">
                    Published
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="published_at">
                    Published On
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="venue_name">
                    Venue
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="venue_state">
                    State
                </matrix-column-visibility-item>
                <matrix-column-visibility-item field="venue_city">
                    City
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
import {EyeIcon as EyeIconOutline, PencilAltIcon} from "@heroicons/vue/outline";
import {XCircleIcon, CheckCircleIcon, EyeIcon as EyeIconSolid, EyeOffIcon, TrashIcon, PlusSmIcon} from "@heroicons/vue/solid"
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
import MatrixColumnVisibility from "@/Components/Matrix/MatrixColumnVisibility";
import MatrixColumnVisibilityItem from "@/Components/Matrix/MatrixColumnVisibilityItem";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
import MatrixFilterDate from "@/Components/Matrix/MatrixFilterDate";
import MatrixRowAction from "@/Components/Matrix/MatrixRowAction";
import MatrixRowActionItem from "@/Components/Matrix/MatrixRowActionItem";
import MatrixFilterSelect from "@/Components/Matrix/MatrixFilterSelect";
export default {
    name: 'EventsMatrix',
    components: {
        MatrixFilterSelect,
        MatrixRowActionItem,
        MatrixRowAction,
        MatrixFilterDate,
        MatrixFilterMenu,
        MatrixFilterSearch,
        MatrixColumnVisibilityItem,
        MatrixColumnVisibility,
        MatrixPagination,
        PlusSmIcon,
        XCircleIcon,
        CheckCircleIcon,
        TrashIcon,
        EyeOffIcon,
        EyeIconSolid,
        EyeIconOutline,
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
        events: {
            type: Object,
            required: true,
        }
    },
    setup(props, context) {
        // Inject Ziggy route helper
        const route = inject('route');

        // Define function to format dates
        const formatDate = (rawDate) => {
            if (rawDate === null) return '';
            let dateObj = new Date(rawDate);
            let dateStr = dateObj.toLocaleDateString('en-US', {
                day: '2-digit',
                month: 'short',
                ...(new Date().getFullYear() !== dateObj.getFullYear() && { year: 'numeric'}),
            });
            let timeStr = dateObj.toLocaleTimeString('en-US', {
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
            });
            return `${dateStr} @ ${timeStr}`;
        };

        return {
            route,
            formatDate,
        };
    },
}
</script>

<style scoped>

</style>
