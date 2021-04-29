<template>
    <div class="w-full flex flex-row justify-between items-center space-x-8">
        <div class="flex items-center space-x-4">
            <select
                :name="`${uid}-row-quantity`"
                :id="`${uid}-row-quantity`"
                v-model="currentRows"
            >
                <option
                    v-for="option in rowOptions"
                    :key="`${uid}-${option}`"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
            <label
                class="font-bold text-sm text-gray-500"
                :for="`${uid}-row-quantity`"
            >
                Rows per page
            </label>
        </div>
        <div class="flex flex-row items-center space-x-4">
            <x-icon-button
                class="!border-none !ring-0 group"
                :disabled="current_page === 1"
                @click="toFirstPage"
            >
                <chevron-double-left-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600 group-disabled:text-gray-400 group-disabled:cursor-default"/>
            </x-icon-button>
            <x-icon-button
                class="!border-none !ring-0 group"
                :disabled="current_page === 1"
                @click="toPrevPage"
            >
                <chevron-left-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600 group-disabled:text-gray-400 group-disabled:cursor-default"/>
            </x-icon-button>
            <p class="font-bold text-sm text-gray-500">
                {{ from ? from : 0 }} - {{ to ? to : 0 }} of {{ total }}
            </p>
            <x-icon-button
                class="!border-none !ring-0 group"
                :disabled="current_page === last_page"
                @click="toNextPage"
            >
                <chevron-right-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600 group-disabled:text-gray-400 group-disabled:cursor-default"/>
            </x-icon-button>
            <x-icon-button
                class="!border-none !ring-0 group"
                :disabled="current_page === last_page"
                @click="toLastPage"
            >
                <chevron-double-right-icon class="h-6 w-6 text-gray-500 group-hover:text-indigo-600 group-disabled:text-gray-400 group-disabled:cursor-default"/>
            </x-icon-button>
        </div>
    </div>
</template>

<script>
import XIconButton from "@/Components/General/XIconButton";
import XText from "@/Components/General/XText";
import {
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
    ChevronLeftIcon,
    ChevronRightIcon
} from "@heroicons/vue/outline/esm";
import {Inertia} from "@inertiajs/inertia";
import {computed, inject} from "vue";

export default {
    name: 'MatrixPagination',
    components: {XIconButton, XText, ChevronDoubleLeftIcon, ChevronLeftIcon, ChevronRightIcon, ChevronDoubleRightIcon},
    props: {},
    setup(props, context) {
        // Inject matrix state
        const uid = inject('uid');
        const pagination = inject('pagination');
        const constraints = inject('constraints');

        // Define computed getters for necessary matrix pagination data
        const first_page_url = computed(() => pagination.value.first_page_url);
        const prev_page_url = computed(() => pagination.value.prev_page_url);
        const next_page_url = computed(() => pagination.value.next_page_url);
        const last_page_url = computed(() => pagination.value.last_page_url);
        const current_page = computed(() => pagination.value.current_page);
        const last_page = computed(() => pagination.value.last_page);
        const from = computed(() => pagination.value.from);
        const to = computed(() => pagination.value.to);
        const total = computed(() => pagination.value.total);

        // Navigate to first page of matrix
        const toFirstPage = () => {
            Inertia.visit(first_page_url.value, {
                preserveScroll: true,
                preserveState: true,
            })
        }

        // Navigate to previous page of matrix
        const toPrevPage = () => {
            Inertia.visit(prev_page_url.value, {
                preserveScroll: true,
                preserveState: true,
            })
        }

        // Navigate to next page of matrix
        const toNextPage = () => {
            Inertia.visit(next_page_url.value, {
                preserveScroll: true,
                preserveState: true,
            })
        }

        // Navigate to last page of matrix
        const toLastPage = () => {
            Inertia.visit(last_page_url.value, {
                preserveScroll: true,
                preserveState: true,
            })
        }

        // Define getter and setter for current row display quantity
        const currentRows = computed({
            get: () => constraints.active.display.row.value,
            set: val => constraints.active.display.row.value = val,
        });

        const rowOptions = computed(() => {
            let options = [5, 10, 15, 25, 50, 75, 100];
            if(!options.includes(constraints.active.display.row.default))
                options.push(constraints.active.display.row.default);
            return options.sort((a, b) => a-b);
        })

        return {
            toFirstPage,
            toPrevPage,
            toNextPage,
            toLastPage,
            current_page,
            last_page,
            from,
            to,
            total,
            first_page_url,
            prev_page_url,
            next_page_url,
            last_page_url,
            currentRows,
            rowOptions,
            uid,
        };
    },
}
</script>

<style scoped>

</style>
