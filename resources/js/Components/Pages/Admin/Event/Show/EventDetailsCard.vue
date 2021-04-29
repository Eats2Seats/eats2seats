<template>
    <div class="grid grid-cols-6 grid-flow-row gap-x-8 md:gap-x-10">
        <x-card class="col-span-6">
            <x-title>
                {{ event.title }}
            </x-title>
            <div class="mt-6 grid grid-cols-3 grid-flow-row gap-4">
                <div>
                    <x-label>Start</x-label>
                    <x-text>{{ formatDate(event.start) }}</x-text>
                </div>
                <div>
                    <x-label>End</x-label>
                    <x-text>{{ formatDate(event.end) }}</x-text>
                </div>
                <div>
                    <x-label>Published</x-label>
                    <x-text>{{ formatDate(event.published_at) }}</x-text>
                </div>
            </div>
        </x-card>
        <x-card class="col-span-6">
            <x-title>{{ venue.name }}</x-title>
            <div class="mt-6 grid grid-cols-2 grid-flow-row gap-4">
                <div>
                    <x-label>Street</x-label>
                    <x-text>{{ venue.street }}</x-text>
                </div>
                <div>
                    <x-label>City</x-label>
                    <x-text>{{ venue.city }}</x-text>
                </div>
                <div>
                    <x-label>State</x-label>
                    <x-text>{{ venue.state }}</x-text>
                </div>
                <div>
                    <x-label>Zip</x-label>
                    <x-text>{{ venue.zip }}</x-text>
                </div>
            </div>
        </x-card>
        <x-card class="col-span-6">
            <x-title>
                Statistics
            </x-title>
            <div class="mt-6 grid grid-cols-2 grid-flow-row gap-4">
                <div>
                    <x-label>Stands</x-label>
                    <x-text>{{ '9 of 13 filled' }}</x-text>
                </div>
                <div>
                    <x-label>Positions</x-label>
                    <x-text>{{ '57 of 72 reserved' }}</x-text>
                </div>
            </div>
        </x-card>
        <div class="col-span-6">
            <matrix
                :matrix="stands"
                :constraints="stand_constraints"
                :route="route('admin.events.show', { id: event.id })"
            >
                <x-card class="w-full">
                    <x-title>Stands</x-title>

                </x-card>
                <matrix-data>
                    <matrix-data-header>
                        <matrix-data-heading>
                            Name
                        </matrix-data-heading>
                        <matrix-data-heading>
                            Location
                        </matrix-data-heading>
                        <matrix-data-heading>
                            Remaining Positions
                        </matrix-data-heading>
                        <matrix-data-heading>
                            Total Positions
                        </matrix-data-heading>
                        <matrix-data-heading>
                            <span class="sr-only">Actions</span>
                        </matrix-data-heading>
                    </matrix-data-header>
                    <matrix-data-body v-slot="{ row }">
                        <matrix-data-cell>
                            {{ row.stand_name }}
                        </matrix-data-cell>
                        <matrix-data-cell>
                            {{ 'location' }}
                        </matrix-data-cell>
                        <matrix-data-cell>
                            {{ 'remaining' }}
                        </matrix-data-cell>
                        <matrix-data-cell>
                            {{ row.positions_total }}
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
        </div>
<!--        <div class="col-span-6">-->
<!--            <matrix-->
<!--                :matrix="reservations"-->
<!--                :constraints="reservation_constraints"-->
<!--                :route="route('admin.events.show', { id: event.id })"-->
<!--            >-->
<!--                <x-card class="w-full">-->
<!--                    <x-title>Reservations</x-title>-->
<!--                    <div class="mt-6 flex">-->
<!--&lt;!&ndash;                        <matrix-filter-search field="user" instant class="mr-4"/>&ndash;&gt;-->
<!--                        <matrix-filter-menu title="Filter Reservations">-->

<!--                        </matrix-filter-menu>-->
<!--                    </div>-->
<!--                </x-card>-->
<!--                <matrix-data>-->
<!--                    <matrix-data-header>-->
<!--                        <matrix-data-heading>-->
<!--                            User-->
<!--                        </matrix-data-heading>-->
<!--                        <matrix-data-heading>-->
<!--                            Stand-->
<!--                        </matrix-data-heading>-->
<!--                        <matrix-data-heading>-->
<!--                            Position-->
<!--                        </matrix-data-heading>-->
<!--                        <matrix-data-heading>-->
<!--                            Reserved On-->
<!--                        </matrix-data-heading>-->
<!--                        <matrix-data-heading>-->
<!--                            <span class="sr-only">Actions</span>-->
<!--                        </matrix-data-heading>-->
<!--                    </matrix-data-header>-->
<!--                    <matrix-data-body v-slot="{ row }">-->
<!--                        <matrix-data-cell>-->
<!--                            {{ row.user }}-->
<!--                        </matrix-data-cell>-->
<!--                        <matrix-data-cell>-->
<!--                            {{ row.stand_name }}-->
<!--                        </matrix-data-cell>-->
<!--                        <matrix-data-cell>-->
<!--                            {{ row.position }}-->
<!--                        </matrix-data-cell>-->
<!--                        <matrix-data-cell>-->
<!--                            {{ row.updated_at }}-->
<!--                        </matrix-data-cell>-->
<!--                        <matrix-data-cell>-->
<!--                            <div class="flex justify-end space-x-3">-->
<!--                                <eye-icon class="h-6 w-6 text-gray-500"/>-->
<!--                                <pencil-alt-icon class="h-6 w-6 text-gray-500"/>-->
<!--                            </div>-->
<!--                        </matrix-data-cell>-->
<!--                    </matrix-data-body>-->
<!--                </matrix-data>-->
<!--                <matrix-pagination class="mt-4"/>-->
<!--            </matrix>-->
<!--        </div>-->
    </div>
</template>

<script>
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XLabel from "@/Components/General/XLabel";
import XText from "@/Components/General/XText";
import Matrix from "@/Components/Matrix/Matrix";
import MatrixData from "@/Components/Matrix/MatrixData";
import MatrixDataBody from "@/Components/Matrix/MatrixDataBody";
import MatrixDataHeader from "@/Components/Matrix/MatrixDataHeader";
import MatrixDataHeading from "@/Components/Matrix/MatrixDataHeading";
import MatrixDataCell from "@/Components/Matrix/MatrixDataCell";
import {EyeIcon, PencilAltIcon} from "@heroicons/vue/outline";
import MatrixPagination from "@/Components/Matrix/MatrixPagination";
import MatrixFilterSearch from "@/Components/Matrix/MatrixFilterSearch";
import MatrixFilterMenu from "@/Components/Matrix/MatrixFilterMenu";
export default {
    name: 'EventDetailsCard',
    components: {
        MatrixFilterMenu,
        MatrixFilterSearch,
        MatrixPagination,
        EyeIcon,
        PencilAltIcon,
        MatrixDataCell,
        MatrixDataHeading, MatrixDataHeader, MatrixDataBody, MatrixData, Matrix, XText, XLabel, XTitle, XCard},
    props: {
        event: {
            type: Object,
            required: true,
        },
        venue: {
            type: Object,
            required: true,
        },
        stands: {
            type: Object,
            required: true,
        },
        stand_constraints: {
            type: Object,
            required: true,
        },
        reservations: {
            type: Object,
            required: true
        },
        reservation_constraints: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {};
    },
    methods: {
        formatDate (rawDate) {
            let dateObj = new Date(rawDate);
            let dateStr = dateObj.toLocaleDateString('en-US', {
                day: '2-digit',
                weekday: 'short',
                month: 'short',
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
