<template>
    <div class="flex flex-col">
        <label
            class="mb-1.5 font-serif font-normal text-sm text-gray-500"
            :for="`${uid}-${field}-filter-date`"
        >
            <slot></slot>
        </label>
        <input
            type="date"
            :id="`${uid}-${field}-filter-date`"
            :name="`${uid}-${field}-filter-date`"
            v-model="filter"
        >
    </div>
</template>

<script>
import {computed, inject} from "vue";

export default {
    name: 'MatrixFilterDate',
    components: {},
    props: {
        field: {
            type: String,
            required: true,
        },
        instant: {
            type: Boolean,
            required: false,
            default: false,
        }
    },
    setup(props, context) {
        // Inject matrix state
        const uid = inject('uid');
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
            uid,
            filter
        };
    },
}
</script>

<style scoped>

</style>
