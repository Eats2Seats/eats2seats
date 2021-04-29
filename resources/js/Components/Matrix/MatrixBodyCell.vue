<template>
    <td
        v-if="isVisible"
        class="px-6 py-4 whitespace-nowrap"
    >
        <slot></slot>
    </td>
</template>

<script>
import {computed, inject} from "vue";

export default {
    name: 'MatrixBodyCell',
    components: {},
    props: {
        field: {
            type: String,
            required: false,
        }
    },
    setup(props, context) {
        // Inject matrix state
        const constraints = inject('constraints');

        // Declare computed variable to determine the cells visibility
        const isVisible = computed(() => {
            return props.field
                ? constraints.active.display.column[props.field].value
                : true;
        });

        return {
            isVisible,
        };
    },
}
</script>

<style scoped>

</style>
