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
export default {
    name: 'ListFilterSearch',
    components: {
        SearchIcon,
    },
    emits: [
        'filter-update',
        'filter-apply'
    ],
    props: [
        'fields',
        'field',
    ],
    data () {
        return {
            value: this.fields[this.field],
        };
    },
    mounted () {
        this.emitter.on('filter-clear', e => this.value = null);
    },
    watch: {
        value: function () {
            this.emitter.emit('filter-update', {
                field: this.field,
                value: this.value,
            });
            this.emitter.emit('filter-apply');
        }
    },
}
</script>

<style scoped>

</style>
