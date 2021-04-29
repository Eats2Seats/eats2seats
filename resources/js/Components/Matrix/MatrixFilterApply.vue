<template>
    <div @click="applyAllFilters">
        <slot>
            <x-button>
                Apply Filters
            </x-button>
        </slot>
    </div>
</template>

<script>
import XButton from "@/Components/General/XButton";
import {inject} from "vue";
import {cloneDeep} from "lodash";

export default {
    name: 'MatrixFilterApply',
    components: {XButton},
    props: {},
    setup(props, context) {
        // Inject matrix state
        const constraints = inject('constraints');

        // Apply all stored constraints
        const applyAllFilters = () => constraints.active.filter = cloneDeep(constraints.stored.filter);

        return {
            applyAllFilters,
        };
    },
}
</script>

<style scoped>

</style>
