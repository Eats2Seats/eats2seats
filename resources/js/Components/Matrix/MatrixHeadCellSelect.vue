<template>
    <th
        scope="col"
        class="px-6 py-4 text-left"
    >
        <span class="sr-only">Toggle selection of all rows</span>
        <input
            type="checkbox"
            :value="id"
            v-model="selected"
            :class="selected ? '!bg-deselect' : ''"
        >
    </th>
</template>

<script>
import {computed, inject, ref, watch} from "vue";

export default {
    name: 'MatrixHeadCellSelect',
    components: {},
    props: {},
    setup(props, context) {
        // Inject matrix state
        const selectedRows = inject('selected-rows');
        const pagination = inject('pagination');

        // Define computed variable to determine selection state
        const selected = computed({
            get: () => selectedRows.value.length > 0,
            set: val => {
                val
                    ? pagination.value.data.forEach(row => selectedRows.value.push(row.id))
                    : selectedRows.value = [];
            }
    });

        watch(selected, () => {

        })

        return {
            selected,
        };
    },
}
</script>

<style scoped>

</style>
