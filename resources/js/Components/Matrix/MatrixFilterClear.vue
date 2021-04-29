<template>
    <div @click="clearAllFilters">
        <slot>
            <x-button class="border-gray-500 !text-gray-700 hover:bg-gray-500 hover:!text-white">
                Clear Filters
            </x-button>
        </slot>
    </div>
</template>

<script>
import {inject} from "vue";
import {cloneDeep} from "lodash";
import XButton from "@/Components/General/XButton";

export default {
    name: 'MatrixFilterClear',
    components: {XButton},
    props: {},
    setup(props, context) {
        // Inject matrix state
        const constraints = inject('constraints');

        // Apply all stored constraints
        const clearAllFilters = () => {
            Object.keys(constraints.stored.filter).forEach(function (field) {
                constraints.stored.filter[field].value = null;
            });
            constraints.active.filter = cloneDeep(constraints.stored.filter);
        };

        return {
            clearAllFilters,
        };
    },
}
</script>

<style scoped>

</style>
