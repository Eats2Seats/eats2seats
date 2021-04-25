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
    emits: ['clear-all-filters'],
    components: {
        XButton,
    },
    methods: {
        clearAllFilters () {
            emitter.emit('clear-all-filters');
        }
    }
}
</script>

<style scoped>

</style>
