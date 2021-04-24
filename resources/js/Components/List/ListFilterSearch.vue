<template>
    <div class="flex-1 relative rounded shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span>
                <search-icon class="inline mr-2 h-4 w-4 text-gray-500"/>
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
import { SearchIcon } from "@heroicons/vue/outline";
const emitter = require('tiny-emitter/instance');
export default {
    name: 'ListFilterSearch',
    components: {
        SearchIcon,
    },
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
        }
    },
}
</script>

<style scoped>

</style>
