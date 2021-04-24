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
                v-for="option in options[field]"
                :key="option"
                :value="option"
            >
                {{ option }}
            </option>
        </select>
    </div>
</template>

<script>
const emitter = require('tiny-emitter/instance');

export default {
    name: 'ListFilterSelect',
    emits: [
        'filter-update',
    ],
    props: [
        'fields',
        'field',
        'options',
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
        }
    },
}
</script>

<style scoped>

</style>
