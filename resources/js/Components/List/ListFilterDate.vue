<template>
    <div class="flex flex-col">
        <label
            class="mb-1.5 font-serif font-normal text-sm text-gray-500"
            for="filter-date"
        >
            <slot></slot>
        </label>
        <input
            type="date"
            id="filter-date"
            v-model="value"
        >
    </div>
</template>

<script>
const emitter = require('tiny-emitter/instance');

export default {
    name: 'ListFilterDate',
    emits: [
        'store-filter',
        'apply-filter',
    ],
    props: {
        field: {
            type: String,
            required: true,
        },
        instant: {
            type: Boolean,
            required: false,
            default: false,
        }
    },
    data () {
        return {
            value: null,
        };
    },
    mounted () {
        emitter.on('list-filters-initialized', (filters) => {
            this.value = filters.fields[this.field];
        });
        emitter.on('clear-all-filters', e => this.value = null);
    },
    beforeUnmount() {
        emitter.off('list-filters-initialized');
        emitter.off('clear-all-filters');
    },
    watch: {
        value: function () {
            this.instant
                ? emitter.emit('apply-filter', this.field, this.value)
                : emitter.emit('store-filter', this.field, this.value);
        },
    },
}
</script>

<style scoped>

</style>
