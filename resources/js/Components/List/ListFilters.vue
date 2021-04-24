<template>
    <slot></slot>
</template>

<script>
import {throttle} from "lodash";
const emitter = require('tiny-emitter/instance');

export default {
    name: 'ListFilters',
    props: {
        route: {
            required: true,
        },
    },
    data () {
        return {
            form: null,
            fields: null,
        };
    },
    mounted () {
        emitter.on('list-filters-initialized', (filters) => {
            this.form = filters.fields;
            this.fields = Object.assign({}, filters.fields);
        });
        emitter.on('store-filter', (field, value) => this.storeFilter(field, value));
        emitter.on('apply-filter', (field, value) => this.applyFilter(field, value));
        emitter.on('apply-all-filters', this.applyAllFilters);
        emitter.on('clear-all-filters', this.clearAllFilters);
    },
    beforeUnmount () {
        emitter.off('list-filters-initialized');
        emitter.off('update-filter');
        emitter.off('apply-filter');
        emitter.off('apply-all-filters');
    },
    methods: {
        storeFilter (field, value) {
            this.fields[field] = value;
        },
        applyFilter (field, value) {
            this.storeFilter(field, value);
            this.form[field] = value;
        },
        applyAllFilters () {
            this.form = Object.assign({}, this.fields);
        },
        clearAllFilters () {
            Object.keys(this.fields).forEach(key => {
                this.fields[key] = null;
            });
            this.applyAllFilters();
        },
    },
    watch: {
        form: {
            handler: throttle(function () {
                this.$inertia.get(this.route, this.form, {
                    preserveState: true,
                    preserveScroll: true,
                });
            }, 150),
            deep: true,
        }
    }
}
</script>

<style scoped>

</style>
