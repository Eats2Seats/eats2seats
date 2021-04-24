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
        'filter-update',
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
        emitter.on('filter-clear', e => this.value = null);
    },
    beforeUnmount() {
        emitter.off('filter-clear');
    },
    watch: {
        value: function () {
            emitter.emit('filter-update', {
                field: this.field,
                value: this.value,
            });
        },
    },
}
</script>

<style scoped>

</style>
