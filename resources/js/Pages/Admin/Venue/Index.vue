<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <matrix
            :matrix="venues"
            :constraints="venue_constraints"
            :route="route('admin.venues.index')"
        >
            <x-card>
                <x-title>
                    Venues
                </x-title>
                <x-subtitle>
                    A table of all active and inactive venues.
                </x-subtitle>
                <div class="mt-6 flex">
                    <matrix-filter-search field="name" instant class="mr-4"/>
                    <matrix-filter-menu title="Filter Venues">
                        <matrix-filter-select field="city">
                            City
                        </matrix-filter-select>
                        <matrix-filter-select field="state">
                            State
                        </matrix-filter-select>
                    </matrix-filter-menu>
                </div>
            </x-card>
            <matrix-data>
                <matrix-data-header>
                    <matrix-data-heading sort="name">
                        Name
                    </matrix-data-heading>
                    <matrix-data-heading sort="city">
                        City
                    </matrix-data-heading>
                    <matrix-data-heading sort="state">
                        State
                    </matrix-data-heading>
                    <matrix-data-heading>
                        <div class="flex justify-center">
                            Active
                        </div>
                    </matrix-data-heading>
                    <matrix-data-heading>
                        <span class="sr-only">Actions</span>
                    </matrix-data-heading>
                </matrix-data-header>
                <matrix-data-body v-slot="{ row }">
                    <matrix-data-cell>
                        {{ row.name }}
                    </matrix-data-cell>
                    <matrix-data-cell>
                        {{ row.city }}
                    </matrix-data-cell>
                    <matrix-data-cell>
                        {{ row.state }}
                    </matrix-data-cell>
                    <matrix-data-cell>
                        <div class="flex justify-center">
                            <check-circle-icon class="h-6 w-6 text-green-600"/>
                        </div>
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
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XDivider from "@/Components/General/XDivider";
import XSubtitle from "@/Components/General/XSubtitle";
import {SearchIcon, CheckCircleIcon, PencilAltIcon, TrashIcon, EyeIcon} from "@heroicons/vue/outline";
import {FilterIcon} from "@heroicons/vue/solid";
import XIconButton from "@/Components/General/XIconButton";
import Matrix from "@/Components/Matrix/Matrix";
import MatrixData from "@/Components/Matrix/MatrixData";
import MatrixDataHeader from "@/Components/Matrix/MatrixDataHeader";
import MatrixDataBody from "@/Components/Matrix/MatrixDataBody";
import MatrixDataCell from "@/Components/Matrix/MatrixDataCell";
import MatrixDataHeading from "@/Components/Matrix/MatrixDataHeading";
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
import MatrixConstraints from "@/Components/Matrix/MatrixConstraints";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
import MatrixFilterSelect from "@/Components/Matrix/MatrixFilterSelect";
import MatrixSortButton from "@/Components/Matrix/MatrixDataHeading";
export default {
    name: 'Index',
    components: {
        MatrixSortButton,
        MatrixFilterSelect,
        MatrixFilterMenu,
        MatrixFilterSearch,
        MatrixConstraints,
        MatrixPagination,
        MatrixDataCell,
        MatrixDataHeading,
        MatrixDataBody,
        MatrixDataHeader,
        MatrixData,
        Matrix,
        XIconButton,
        XSubtitle,
        XDivider,
        XTitle,
        XCard,
        AdminLayout,
        SearchIcon,
        FilterIcon,
        CheckCircleIcon,
        PencilAltIcon,
        TrashIcon,
        EyeIcon,
    },
    props: {
        venue_constraints: Object,
        venues: Object,
    },
    data() {
        return {
            breadcrumbs: [
                { name: 'Venues', url: window.location.pathname },
            ]
        };
    },
}
</script>

<style scoped>

</style>
