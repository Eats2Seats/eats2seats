<template>
    <div class="flex-1 relative rounded">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="inline-flex justify-center items-center">
                <search-icon class="inline mr-2 h-5 w-5 text-gray-500"/>
            </span>
        </div>
        <input
            class="block w-full pl-10"
            type="text"
            placeholder="Search"
            v-model="value"
        >
    </div>
</template>

<script>
import { SearchIcon } from "@heroicons/vue/solid";
const emitter = require('tiny-emitter/instance');
export default {
    name: 'MatrixFilterSearch',
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
