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
    name: 'ListFilterApplyButton',
    emits: ['apply-all-filters'],
    components: {
        XButton,
    },
    methods: {
        applyAllFilters () {
            emitter.emit('apply-all-filters');
        }
    }
}
</script>

<style scoped>

</style>
