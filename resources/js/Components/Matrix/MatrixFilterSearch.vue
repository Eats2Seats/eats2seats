<template>
    <div class="flex-1 relative rounded">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="inline-flex justify-center items-center">
                <search-icon class="inline mr-2 h-5 w-5 text-gray-500"/>
            </span>
        </div>
        <input
            class="block w-full pl-10 shadow-sm"
            type="text"
            placeholder="Search"
            v-model="filter"
        >
    </div>
</template>

<script>
import {computed, inject, watch} from "vue";
import {SearchIcon} from "@heroicons/vue/outline";

export default {
    name: 'MatrixFilterSearch',
    components: {SearchIcon},
    props: {
        field: {
            type: String,
            required: true,
        },
        instant: {
            type: Boolean,
            required: false,
        }
    },
    setup(props, context) {
        // Inject the matrix state
        const constraints = inject('constraints');

        // Define a getter and setter for the filter value
        const filter = computed({
            get: () => {
                return props.instant
                    ? constraints.active.filter[props.field].value
                    : constraints.stored.filter[props.field].value;
            },
            set: val => {
                return props.instant
                    ? constraints.active.filter[props.field].value = val
                    : constraints.stored.filter[props.field].value = val;
            }
        });

        return {
            filter
        };
    },
}
</script>

<style scoped>

</style>
