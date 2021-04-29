<template>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="sr-only">Toggle selection of this row</span>
        <input
            type="checkbox"
            :value="id"
            v-model="selected"
        >
    </td>
</template>

<script>
import {computed, inject, ref, watch} from 'vue';
export default {
    name: 'MatrixBodyCellSelect',
    components: {},
    props: {
        id: {
            type: Number,
            required: true
        }
    },
    setup(props, context) {
        // Inject the matrix state
        const selectedRows = inject('selected-rows');

        // Define computed variable to track selection state
        const selected = computed({
            get: () => selectedRows.value.includes(props.id),
            set: val => {
                val
                    ? selectedRows.value.push(props.id)
                    : selectedRows.value.splice(selectedRows.value.indexOf(props.id), 1);
            }
        })

        return {
            selected,
        };
    },
}
</script>

<style scoped>

</style>
