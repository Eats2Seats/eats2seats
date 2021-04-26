<template>
    <div @click="clearAllFilters">
        <slot>
            <x-button class="!text-gray-500 !border-gray-400 hover:!bg-gray-500 hover:!text-white">
                Clear Filters
            </x-button>
        </slot>
    </div>
</template>

<script>
import XButton from "@/Components/General/XButton";
const emitter = require('tiny-emitter/instance');

export default {
    name: 'ListFilterClearButton',
    emits: [
        'matrix-constraint-filter-clear-all'
    ],
    components: {
        XButton,
    },
    methods: {
        clearAllFilters () {
            emitter.emit('matrix-constraint-filter-clear-all');
        }
    }
}
</script>

<style scoped>

</style>
