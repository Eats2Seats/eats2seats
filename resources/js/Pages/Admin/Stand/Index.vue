<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <matrix
            :matrix="stands"
            :constraints="stand_constraints"
            :route="route('admin.stands.index')"
        >
            <x-card>
                <x-title>
                    Stands
                </x-title>
                <x-subtitle>
                    A table of all venue stands.
                </x-subtitle>
                <div class="mt-6 flex">
                    <matrix-filter-search field="default_name" instant class="mr-4"/>
                    <matrix-filter-menu title="Filter Stands">
                        <matrix-filter-select field="venue_name">
                            Venue
                        </matrix-filter-select>
                    </matrix-filter-menu>
                </div>
            </x-card>
            <matrix-data>
                <matrix-data-header>
                    <matrix-data-heading sort="default_name">
                        Default Name
                    </matrix-data-heading>
                    <matrix-data-heading sort="stand_location">
                        Location
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
                        {{ row.default_name }}
                    </matrix-data-cell>
                    <matrix-data-cell>
                        {{ row.stand_location }}
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
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
import {EyeIcon, PencilAltIcon} from "@heroicons/vue/outline";
import XTitle from "@/Components/General/XTitle";
import XSubtitle from "@/Components/General/XSubtitle";
import XCard from "@/Components/General/XCard";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
import MatrixFilterSelect from "@/Components/Matrix/MatrixFilterSelect";
export default {
    name: 'Index',
    components: {
        MatrixFilterSelect,
        MatrixFilterMenu,
        MatrixFilterSearch,
        XCard,
        XTitle,
        XSubtitle,
        EyeIcon,
        PencilAltIcon,
        MatrixPagination,
        MatrixDataCell,
        MatrixDataBody,
        MatrixDataHeading,
        MatrixDataHeader,
        MatrixData,
        Matrix,
        AdminLayout
    },
    props: {
        stands: {
            type: Object,
            required: true,
        },
        stand_constraints: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            breadcrumbs: [
                { name: 'Stands', url: window.location.pathname },
            ]
        };
    },
}
</script>

<style scoped>

</style>
