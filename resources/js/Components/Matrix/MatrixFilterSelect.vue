<template>
    <div class="flex flex-col">
        <label
            class="mb-1.5 font-serif font-normal text-sm text-gray-500"
            :for="`filter-select-${field}`"
        >
            <slot></slot>
        </label>
        <select
            :name="`filter-select-${field}`"
            :id="`filter-select-${field}`"
            v-model="value"
        >
            <option :value="null">
                <slot name="default-option">All</slot>
            </option>
            <option
                v-for="option in options"
                :key="option"
                :value="option"
            >
                {{ option }}
            </option>
        </select>
    </div>
</template>

<script>
import { SearchIcon } from "@heroicons/vue/solid";
const emitter = require('tiny-emitter/instance');
export default {
    name: 'MatrixFilterSelect',
    components: {
        SearchIcon,
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
            options: null,
        };
    },
    mounted () {
        emitter.on('matrix-constraints-updated', (constraints) => {
            this.value = constraints.fields[this.field].filter_value;
            this.options = constraints.fields[this.field].filter_options;
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
