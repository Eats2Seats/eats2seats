<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <matrix
            uid="events"
            :route="route('admin.events.index')"
            :data="events"
        >
            <x-card>
                <matrix-filter-search field="title" instant/>
                <matrix-filter-date field="start"/>
                <matrix-filter-date field="end"/>
                <matrix-filter-date field="published_at"/>
                <matrix-filter-apply/>
                <matrix-filter-clear/>
            </x-card>
            <matrix-table>
                <template #head>
                    <matrix-heading sort="title">
                        Title
                    </matrix-heading>
                    <matrix-heading sort="start">
                        Start
                    </matrix-heading>
                    <matrix-heading sort="end">
                        End
                    </matrix-heading>
                    <matrix-heading sort="published_at">
                        Published At
                    </matrix-heading>
                    <matrix-heading>
                        <span class="sr-only">Actions</span>
                    </matrix-heading>
                </template>
                <template v-slot:body="{ row }">
                    <matrix-cell field="title">
                        {{ row.title }}
                    </matrix-cell>
                    <matrix-cell field="start">
                        {{ row.start }}
                    </matrix-cell>
                    <matrix-cell field="end">
                        {{ row.end }}
                    </matrix-cell>
                    <matrix-cell field="published_at">
                        {{ row.published_at }}
                    </matrix-cell>
                    <matrix-cell>
                        <div class="flex justify-end space-x-3">
                            <eye-icon class="h-6 w-6 text-gray-500"/>
                            <pencil-alt-icon class="h-6 w-6 text-gray-500"/>
                        </div>
                    </matrix-cell>
                </template>
            </matrix-table>
            <matrix-pagination/>
            <matrix-display-rows/>
        </matrix>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout";
import {inject} from "vue";
import Matrix from "@/Components/DataTable/Matrix";
import MatrixPagination from "@/Components/DataTable/MatrixPagination";
import MatrixCell from "@/Components/DataTable/MatrixCell";
import MatrixTable from "@/Components/DataTable/MatrixTable";
import XCard from "@/Components/General/XCard";
import MatrixHeading from "@/Components/DataTable/MatrixHeading";
import {EyeIcon, PencilAltIcon} from "@heroicons/vue/outline";
import MatrixFilterSearch from "@/Components/DataTable/MatrixFilterSearch";
import MatrixFilterApply from "@/Components/DataTable/MatrixFilterApply";
import XButton from "@/Components/General/XButton";
import MatrixFilterDate from "@/Components/DataTable/MatrixFilterDate";
import MatrixFilterClear from "@/Components/DataTable/MatrixFilterClear";
import MatrixDisplayRows from "@/Components/DataTable/MatrixDisplayRows";
export default {
    name: 'Show',
    components: {
        MatrixDisplayRows,
        MatrixFilterClear,
        MatrixFilterDate,
        XButton,
        MatrixFilterApply,
        MatrixFilterSearch,
        MatrixHeading,
        XCard,
        MatrixTable,
        MatrixCell,
        MatrixPagination,
        Matrix,
        AdminLayout,
        EyeIcon,
        PencilAltIcon,
    },
    props: {
        events: {
            type: Object,
            required: true,
        },
    },
    setup (props, context) {
        const route = inject('route');

        const breadcrumbs = [
            { name: 'Events', url: route('admin.events.index') },
            { name: 'Event', url: window.location.pathname },
        ];

        return {
            breadcrumbs,
            route,
        };
    }
}
</script>

<style scoped>

</style>
