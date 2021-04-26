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
    name: 'MatrixFilterDate',
    components: {

    },
    emits: [
        'matrix-constraint-filter-apply',
        'matrix-constraint-filter-store',
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
        emitter.on('matrix-constraints-updated', (constraints) => {
            this.value = constraints.fields[this.field].filter_value;
        });
        emitter.on('matrix-constraint-filter-clear-all', e => this.value = null);
    },
    beforeUnmount() {
        emitter.off('matrix-constraints-updated');
        emitter.off('matrix-constraint-filter-clear-all');
    },
    watch: {
        value: function () {
            this.instant
                ? emitter.emit('matrix-constraint-filter-apply', this.field, this.value)
                : emitter.emit('matrix-constraint-filter-store', this.field, this.value);
        }
    },
}
</script>

<style scoped>

</style>

