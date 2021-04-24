<template>
    <slot :fields="form"></slot>
</template>

<script>
import {throttle} from "lodash";
const emitter = require('tiny-emitter/instance');

export default {
    name: 'ListFilters',
    props: {
        routeName: {
            type: String,
            required: true,
        },
    },
    data () {
        return {
            form: this.$parent.$props.filters.fields,
        };
    },
    mounted () {
        emitter.on('filter-update', (filter) => this.updateFilterOptions(filter));
        emitter.on('filter-apply', e => this.applyFilterOptions());
        emitter.on('filter-clear', e => this.applyFilterOptions());
    },
    beforeUnmount () {
        emitter.off('filter-update');
        emitter.off('filter-apply');
        emitter.off('filter-clear');
    },
    methods: {
        updateFilterOptions (filter) {
            this.form[filter.field] = filter.value;
        },
        applyFilterOptions: throttle(function () {
            this.$inertia.get(this.route(this.routeName), this.form, {
                preserveState: true,
                preserveScroll: true,
            });
        }, 150),
    },
}
</script>

<style scoped>

</style>
