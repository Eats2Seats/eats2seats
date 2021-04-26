<template>
    <th
        v-if="sort"
        @click="toggleSort"
        scope="col"
        class="px-6 py-4 text-left cursor-pointer"
    >
        <div class="flex justify-between items-center">
            <slot></slot>
            <div v-if="direction === 'ASC'" class="flex items-center space-x-1">
                <p class="flex justify-center items-center text-gray-500 font-bold text-xs leading-0">
                    {{ order }}
                </p>
                <arrow-circle-up-icon class="h-5 w-5 text-gray-500"/>
            </div>
            <div v-if="direction === 'DESC'" class="flex items-center space-x-1">
                <p class="flex justify-center items-center text-gray-500 font-bold text-xs leading-0">
                    {{ order }}
                </p>
                <arrow-circle-down-icon class="h-5 w-5 text-gray-500"/>
            </div>
        </div>
    </th>
    <th
        v-else
        scope="col"
        class="px-6 py-4 text-left"
    >
        <slot></slot>
    </th>
</template>

<script>
import {ArrowCircleUpIcon, ArrowCircleDownIcon} from "@heroicons/vue/solid/esm";

const emitter = require('tiny-emitter/instance');
export default {
    name: 'MatrixDataHeading',
    components: {
        ArrowCircleDownIcon,
        ArrowCircleUpIcon
    },
    emits: [
        'matrix-constraint-sort-apply'
    ],
    props: {
        sort: {
            type: String,
            required: false,
        }
    },
    data() {
        return {
            direction: null,
            order: null,
        };
    },
    mounted () {
        if (this.sort) {
            emitter.on('matrix-constraints-updated', (constraints) => {
                this.direction = constraints.fields[this.sort].sort_value;
                this.sortOrder(constraints.sort);
            });
            emitter.on('matrix-constraint-sort-applied', (sort) => this.sortOrder(sort))
        }
    },
    beforeUnmount () {
        emitter.off('matrix-constraints-updated');
        emitter.off('matrix-constraint-sort-applied');
    },
    methods: {
        toggleSort () {
            if (this.direction === null) {
                this.direction = 'ASC';
            }
            else if (this.direction === 'ASC') {
                this.direction = 'DESC';
            }
            else {
                this.direction = null;
            }
        },
        sortOrder (sort) {
            sort.indexOf(this.sort) !== -1
                ? this.order = sort.indexOf(this.sort) + 1
                : this.order = null;
        }
    },
    watch: {
        direction () {
            emitter.emit('matrix-constraint-sort-apply', this.sort, this.direction);
        }
    }
}
</script>

<style scoped>

</style>
