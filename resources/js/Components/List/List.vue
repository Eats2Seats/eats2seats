<template>
    <slot></slot>
</template>

<script>
const emitter = require('tiny-emitter/instance');

export default {
    name: 'List',
    emits: [
        'list-filters-initialized',
        'list-items-updated',
    ],
    props: {
        items: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            required: false,
        }
    },
    data () {
        return {
            unapplied_fields: Object.assign({}, this.filters.fields),
        };
    },
    mounted () {
        emitter.emit('list-filters-initialized', this.filters);
        emitter.emit('list-items-updated', this.items);
    },
    watch: {
        items: {
            handler: function () {
                emitter.emit('list-items-updated', this.items);
            },
            deep: true,
        }
    }
}
</script>

<style scoped>

</style>
