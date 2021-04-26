<template>
    <slot></slot>
</template>

<script>
import {cloneDeep, throttle} from "lodash";

const emitter = require('tiny-emitter/instance');

export default {
    name: 'MatrixConstraints',
    components: {},
    emits: [
        'matrix-constraint-sort-applied',
    ],
    props: {
        route: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            form: {
                fields: {},
                sort: [],
                group: [],
            },
            constraints: {
                fields: {},
                sort: [],
                group: [],
            }
        };
    },
    async mounted () {
        await emitter.on('matrix-constraints-updated', (constraints) => {
            this.form = constraints
            this.constraints = cloneDeep(constraints);
        })
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
            this.constraints.fields[field].filter_value = value;
        },
        applyFilter (field, value) {
            this.storeFilter(field, value);
            this.form.fields[field].filter_value = value;
        },
        applyAllFilters () {
            Object.keys(this.constraints.fields).forEach(function (field) {
                this.form.fields[field].filter_value = this.constraints.fields[field].filter_value;
            }, this);
        },
        clearAllFilters () {
            Object.keys(this.constraints.fields).forEach(function (field) {
                this.constraints.fields[field].filter_value = null;
            }, this);
            this.applyAllFilters();
        },
        storeSort (field, direction) {
            this.constraints.fields[field].sort_value = direction;
            if (direction === null) {
                let index = this.constraints.sort.indexOf(field);
                this.constraints.sort.splice(index, 1);
            }
            else if (this.constraints.sort.indexOf(field) === -1) {
                this.constraints.sort.push(field);
            }
        },
        applySort (field, direction) {
            this.storeSort(field, direction);
            this.form.fields[field].sort_value = this.constraints.fields[field].sort_value;
            this.form.sort = cloneDeep(this.constraints.sort);
            emitter.emit('matrix-constraint-sort-applied', this.form.sort);
        },
        applyAllConstraints () {
            this.form = cloneDeep(this.constraints);
        },
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = {};
                Object.keys(this.form.fields).forEach(function (field) {
                    if (this.constraints.fields[field].filter_value) {
                        query[`filter_${field}`] = this.form.fields[field].filter_value;
                    }
                    if (this.constraints.fields[field].sort_value) {
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
    },
}
</script>

<style scoped>

</style>
