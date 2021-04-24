<template>
    <slot :fields="form"></slot>
</template>

<script>
import {throttle} from "lodash";
export default {
    name: 'ListFilters',
    data () {
        return {
            form: this.$parent.$props.filters.fields,
        };
    },
    mounted () {
        this.emitter.on('filter-update', (filter) => this.updateFilterOptions(filter));
        this.emitter.on('filter-apply', e => this.applyFilterOptions());
        this.emitter.on('filter-clear', e => this.applyFilterOptions());
    },
    methods: {
        updateFilterOptions (filter) {
            this.form[filter.field] = filter.value;
        },
        applyFilterOptions: throttle(function () {
            this.$inertia.get(this.route('volunteer.reservations.index'), this.form, {
                preserveState: true,
                preserveScroll: true,
            });
        }, 150),
    },
}
</script>

<style scoped>

</style>
