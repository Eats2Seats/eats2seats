<template>
    <div class="flex flex-col">
        <label
            class="mb-1.5 font-serif font-normal text-sm text-gray-500"
            :for="`${uid}-${field}-filter-select`"
        >
            <slot></slot>
        </label>
        <select
            :name="`${uid}-${field}-filter-select`"
            :id="`${uid}-${field}-filter-select`"
            v-model="filter"
        >
            <option :value="null">
                <slot name="default-option">All</slot>
            </option>
            <option
                v-for="option in options"
                :key="option"
                :value="option"
            >
                {{ option }}
            </option>
        </select>
    </div>
</template>

<script>
import {computed, inject} from "vue";

export default {
    name: 'MatrixFilterSelect',
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

        // Define a getter for the filter options
        const options = computed(() => constraints.active.filter[props.field].options);

        return {
            uid,
            filter,
            options
        };
    },
}
</script>

<style scoped>

</style>
