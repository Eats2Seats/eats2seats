<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <matrix
            :matrix="events"
            :constraints="event_constraints"
            :route="route('admin.events.index')"
        >
            <x-card>
                <x-title>
                    Events
                </x-title>
                <x-subtitle>
                    A table of all events.
                </x-subtitle>
                <div class="mt-6 flex">
                    <matrix-filter-search field="title" instant class="mr-4"/>
                    <matrix-filter-menu title="Filter Events">
                        <matrix-filter-date field="start">
                            Start
                        </matrix-filter-date>
                        <matrix-filter-date field="end">
                            End
                        </matrix-filter-date>
                        <matrix-filter-date field="published_at">
                            Published
                        </matrix-filter-date>
                        <matrix-filter-select field="venue_name">
                            Venue
                        </matrix-filter-select>
                    </matrix-filter-menu>
                </div>
            </x-card>
            <matrix-data>
                <matrix-data-header>
                    <matrix-data-heading sort="title">
                        Title
                    </matrix-data-heading>
                    <matrix-data-heading sort="start">
                        Start
                    </matrix-data-heading>
                    <matrix-data-heading sort="end">
                        End
                    </matrix-data-heading>
                    <matrix-data-heading sort="published_at">
                        Published
                    </matrix-data-heading>
                    <matrix-data-heading sort="venue_name">
                        Venue
                    </matrix-data-heading>
                    <matrix-data-heading>
                        <span class="sr-only">Actions</span>
                    </matrix-data-heading>
                </matrix-data-header>
                <matrix-data-body v-slot="{ row }">
                    <matrix-data-cell>
                        {{ row.title }}
                    </matrix-data-cell>
                    <matrix-data-cell>
                        {{ formatDate(row.start) }}
                    </matrix-data-cell>
                    <matrix-data-cell>
                        {{ formatDate(row.end) }}
                    </matrix-data-cell>
                    <matrix-data-cell>
                        {{ formatDate(row.published_at) }}
                    </matrix-data-cell>
                    <matrix-data-cell>
                        <inertia-link
                            :href="route('admin.venues.show', { id: row.venue_id })"
                            class="underline"
                        >
                            {{ row.venue_name }}
                        </inertia-link>
                    </matrix-data-cell>
                    <matrix-data-cell>
                        <div class="flex justify-end space-x-3">
                            <eye-icon class="h-6 w-6 text-gray-500"/>
                            <pencil-alt-icon class="h-6 w-6 text-gray-500"/>
                        </div>
                    </matrix-data-cell>
                </matrix-data-body>
            </matrix-data>
            <matrix-pagination class="mt-4"/>
        </matrix>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout";
import Matrix from "@/Components/Matrix/Matrix";
import MatrixData from "@/Components/Matrix/MatrixData";
import MatrixDataHeader from "@/Components/Matrix/MatrixDataHeader";
import MatrixDataHeading from "@/Components/Matrix/MatrixDataHeading";
import MatrixDataBody from "@/Components/Matrix/MatrixDataBody";
import MatrixDataCell from "@/Components/Matrix/MatrixDataCell";
import {EyeIcon, PencilAltIcon} from "@heroicons/vue/outline";
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
import XSubtitle from "@/Components/General/XSubtitle";
import XTitle from "@/Components/General/XTitle";
import XCard from "@/Components/General/XCard";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixFilterSelect from "@/Components/Matrix/MatrixFilterSelect";
import MatrixFilterDate from "@/Components/Matrix/MatrixFilterDate";
export default {
    name: 'Index',
    components: {
        MatrixFilterDate,
        MatrixFilterMenu,
        MatrixFilterSearch,
        MatrixFilterSelect,
        XCard,
        XTitle,
        XSubtitle,
        MatrixPagination,
        EyeIcon, PencilAltIcon, MatrixDataCell, MatrixDataBody, MatrixDataHeading, MatrixDataHeader, MatrixData, Matrix, AdminLayout},
    props: {
        events: {
            type: Object,
            required: true,
        },
        event_constraints: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            breadcrumbs: [
                { name: 'Events', url: window.location.pathname },
            ]
        };
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
            return `${dateStr}  ${timeStr}`;
        },
    }
}
</script>

<style scoped>

</style>
