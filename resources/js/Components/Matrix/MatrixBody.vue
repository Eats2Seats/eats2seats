<template>
    <tbody class="bg-white divide-y divide-gray-200">
        <tr
            v-for="(row, index) in rows"
            :key="`${uid}-${index}`"
            class="even:bg-gray-50"
            :class="isSelected(row.id) ? '!bg-indigo-100' : ''"
        >
            <slot :row="row"></slot>
        </tr>
    </tbody>
</template>

<script>
import {computed, inject} from "vue";

export default {
    name: 'MatrixBody',
    components: {},
    props: {},
    setup(props, context) {
        // Inject matrix state
        const uid = inject('uid');
        const pagination = inject('pagination');
        const selectedRows = inject('selected-rows');

        // Define rows to reactively get paginated data
        const rows = computed(() => pagination.value.data);

        // Define method to determine if the row is selected
        const isSelected = (row) => {
            return selectedRows.value.includes(row);
        }

        return {
            uid,
            rows,
            isSelected,
        }
    },
}
</script>

<style scoped>

</style>
