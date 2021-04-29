<template>
    <div class="mt-8 md:mt-10 bg-gray-50">
        <slot :rowsSelected="selectedRows.length > 0"></slot>
    </div>
</template>

<script>
import {watch, provide, reactive, computed, ref} from 'vue'
import {Inertia} from "@inertiajs/inertia";

export default {
    name: 'Matrix',
    components: {},
    props: {
        data: {
            type: Object,
            required: true
        },
        route: {
            type: String,
            required: true,
        }
    },
    setup(props, context) {
        // Define UID value via computed to maintain reactivity with data prop
        const uid = computed(() => props.data.uid);

        // Define pagination object via computed to maintain reactivity with data prop
        const pagination = computed(() => {
            return {
                current_page: props.data.pagination.current_page ?? null,
                data: props.data.pagination.data ?? [],
                first_page_url: props.data.pagination.first_page_url ?? null,
                from: props.data.pagination.from ?? null,
                last_page: props.data.pagination.last_page ?? null,
                last_page_url: props.data.pagination.last_page_url ?? null,
                links: props.data.pagination.links ?? [],
                next_page_url: props.data.pagination.next_page_url ?? null,
                path: props.data.pagination.path ?? null,
                per_page: props.data.pagination.per_page ?? null,
                prev_page_url: props.data.pagination.prev_page_url ?? null,
                to: props.data.pagination.to ?? null,
                total: props.data.pagination.total ?? null,
            };
        });

        // Define reactive constraints object and remove reactivity with data prop
        const constraints = reactive({
            active: {
                filter: _.cloneDeep(props.data.filter) ?? {},
                sort: {
                    direction: _.cloneDeep(props.data.sort.direction) ?? {},
                    priority: _.cloneDeep(props.data.sort.priority) ?? [],
                },
                display: {
                    column: _.cloneDeep(props.data.display.column) ?? {},
                    row: _.cloneDeep(props.data.display.row) ?? {},
                }
            },
            stored: {
                filter: _.cloneDeep(props.data.filter) ?? {},
            },
        });

        // Define reactive variable to track selected rows for multi-row actions
        const selectedRows = ref([]);

        // Provide the matrix state data
        provide('uid', uid);
        provide('pagination', pagination);
        provide('constraints', constraints);
        provide('selected-rows', selectedRows);

        // Define watcher to update matrix pagination on active constraints change
        watch(constraints.active, _.throttle(() => {
            // Remove all selected rows
            selectedRows.value = [];

            // Get existing query string from URL
            const query = new URLSearchParams(window.location.search);

            // Create query parameters for fields with filter values
            Object.keys(constraints.active.filter).forEach((field) => {
                (constraints.active.filter[field].value !== null && constraints.active.filter[field].value !== '')
                    ? query.set(`${uid.value}[filter][${field}]`, constraints.active.filter[field].value)
                    : query.delete(`${uid.value}[filter][${field}]`);
            });

            // Delete all existing sort priority query parameters
            query.delete(`${uid.value}[sort_priority][]`);

            // Create query parameters for fields with sort priority
            constraints.active.sort.priority.forEach((field, index) => {
                query.append(`${uid.value}[sort_priority][]`, field);
            });

            // Create query parameters for fields with sort values
            Object.keys(constraints.active.sort.direction).forEach((field) => {
                constraints.active.sort.direction[field] !== null
                    ? query.set(`${uid.value}[sort][${field}]`, constraints.active.sort.direction[field])
                    : query.delete(`${uid.value}[sort][${field}]`);
            });

            // Create query parameters for fields with visibility values
            Object.keys(constraints.active.display.column).forEach((field) => {
                constraints.active.display.column[field].value !== constraints.active.display.column[field].default
                    ? query.set(`${uid.value}[display_column][${field}]`, constraints.active.display.column[field].value)
                    : query.delete(`${uid.value}[display_column][${field}]`);
            });

            // Create query parameter for quantity of rows to display
            constraints.active.display.row.value !== constraints.active.display.row.default
                ? query.set(`${uid.value}[display_row]`, constraints.active.display.row.value)
                : query.delete(`${uid.value}[display_row]`);

            // Fetch constrained data from the backend
            Inertia.get(`${props.route}${query.toString() === '' ? '' : '?' + query.toString()}`, {}, {
                preserveScroll: true,
                preserveState: true,
            });

            // Update stored constraints to match active constraints
            constraints.stored.filter = _.cloneDeep(constraints.active.filter);
        }, 150), {
            deep: true,
        });

        return {
            uid,
            pagination,
            constraints,
            selectedRows,
        };
    },
}
</script>

<style scoped>

</style>
