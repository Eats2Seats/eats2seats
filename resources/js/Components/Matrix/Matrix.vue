<template>
    <slot></slot>
</template>

<script>
import {cloneDeep, throttle} from "lodash";

const emitter = require('tiny-emitter/instance');

export default {
    name: 'Matrix',
    components: {},
    emits: [
        'matrix-data-updated',
        'matrix-constraints-updated',
        'matrix-constraint-sort-applied',
    ],
    props: {
        matrix: {
            type: Object,
            required: true,
        },
        constraints: {
            type: Object,
            required: false,
        },
        route: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            constraintStore: {
                fields: {},
                sort: [],
                group: [],
            },
            form: {
                fields: {},
                sort: [],
                group: [],
            },
        };
    },
    mounted () {
        emitter.emit('matrix-data-updated', this.matrix);
        emitter.emit('matrix-constraints-updated', this.constraints);
        this.form = this.constraints;
        this.constraintStore = cloneDeep(this.constraints)
        emitter.on('matrix-constraint-filter-store', (field, value) => this.storeFilter(field, value));
        emitter.on('matrix-constraint-filter-apply', (field, value) => this.applyFilter(field, value));
        emitter.on('matrix-constraint-filter-apply-all', this.applyAllFilters);
        emitter.on('matrix-constraint-filter-clear-all', this.clearAllFilters);
        emitter.on('matrix-constraint-sort-apply', (field, direction) => this.applySort(field, direction));
    },
    beforeUnmount () {
        emitter.off('matrix-constraint-filter-store');
        emitter.off('matrix-constraint-filter-apply');
        emitter.off('matrix-constraint-filter-apply-all');
        emitter.off('matrix-constraint-filter-clear-all');
        emitter.off('matrix-constraint-sort-apply');
    },
    methods: {
        storeFilter (field, value) {
            this.constraintStore.fields[field].filter_value = value;
        },
        applyFilter (field, value) {
            this.storeFilter(field, value);
            this.form.fields[field].filter_value = value;
        },
        applyAllFilters () {
            Object.keys(this.constraintStore.fields).forEach(function (field) {
                this.form.fields[field].filter_value = this.constraintStore.fields[field].filter_value;
            }, this);
        },
        clearAllFilters () {
            Object.keys(this.constraintStore.fields).forEach(function (field) {
                this.constraintStore.fields[field].filter_value = null;
            }, this);
            this.applyAllFilters();
        },
        storeSort (field, direction) {
            this.constraintStore.fields[field].sort_value = direction;
            if (direction === null) {
                let index = this.constraintStore.sort.indexOf(field);
                this.constraintStore.sort.splice(index, 1);
            }
            else if (this.constraintStore.sort.indexOf(field) === -1) {
                this.constraintStore.sort.push(field);
            }
        },
        applySort (field, direction) {
            this.storeSort(field, direction);
            this.form.fields[field].sort_value = this.constraintStore.fields[field].sort_value;
            this.form.sort = cloneDeep(this.constraintStore.sort);
            emitter.emit('matrix-constraint-sort-applied', this.form.sort);
        },
        applyAllConstraints () {
            this.form = cloneDeep(this.constraintStore);
        },
    },
    watch: {
        matrix: {
            handler: function () {
                emitter.emit('matrix-data-updated', this.matrix);
            },
            deep: true,
        },
        form: {
            handler: throttle(function () {
                let query = {};
                Object.keys(this.form.fields).forEach(function (field) {
                    if (this.constraintStore.fields[field].filter_value) {
                        query[`filter_${field}`] = this.form.fields[field].filter_value;
                    }
                    if (this.constraintStore.fields[field].sort_value) {
                        query[`sort_${field}`] = this.form.fields[field].sort_value;
                    }
                }, this);
                query.sort = this.form.sort.filter(function (field) {
                    return this.form.fields.hasOwnProperty(field);
                }, this);
                console.log(query);
                this.$inertia.get(this.route, query, {
                    preserveScroll: true,
                    preserveState: true,
                });
            }, 150),
            deep: true,
        }
    }
}
</script>

<style scoped>

</style>
