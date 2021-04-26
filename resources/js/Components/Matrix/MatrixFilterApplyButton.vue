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
const emitter = require('tiny-emitter/instance');

export default {
    name: 'MatrixFilterApplyButton',
    emits: [
        'matrix-constraint-filter-apply-all'
    ],
    components: {
        XButton,
    },
    methods: {
        applyAllFilters () {
            emitter.emit('matrix-constraint-filter-apply-all');
        }
    }
}
</script>

<style scoped>

</style>

