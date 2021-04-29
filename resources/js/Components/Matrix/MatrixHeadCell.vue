<template>
    <th
        v-if="field && isVisible"
        scope="col"
        class="px-6 py-4 text-left cursor-pointer hover:bg-gray-100"
        @click="toggleDirection"
    >
        <div class="flex justify-between items-center">
            <slot></slot>
            <div class="flex items-center space-x-1">
                <p class="flex justify-center items-center text-gray-500 font-bold text-xs leading-0">
                    {{ priority }}
                </p>
                <arrow-circle-up-icon
                    class="h-5 w-5 text-gray-500"
                    v-if="direction === 'ASC'"
                />
                <arrow-circle-down-icon
                    class="h-5 w-5 text-gray-500"
                    v-if="direction === 'DESC'"
                />
            </div>
        </div>
    </th>
    <th
        v-else-if="isVisible"
        scope="col"
        class="px-6 py-4 text-left"
    >
            <slot></slot>
    </th>
</template>

<script>
import {computed, inject} from "vue";
import {ArrowCircleDownIcon, ArrowCircleUpIcon} from "@heroicons/vue/solid/esm";

export default {
    name: 'MatrixHeadCell',
    components: {ArrowCircleUpIcon, ArrowCircleDownIcon},
    props: {
        field: {
            type: String,
            required: false
        }
    },
    setup(props, context) {
        // Inject the matrix state
        const constraints = inject('constraints');

        // Define a getter and setter for controlling the column's sort direction
        const direction = computed({
            get: () => constraints.active.sort.direction[props.field],
            set: val => constraints.active.sort.direction[props.field] = val,
        });

        // Define a getter for controlling the column's sort priority
        const priority = computed({
            get: () => {
                let index = constraints.active.sort.priority.indexOf(props.field);
                return index !== -1
                    ? index + 1
                    : null;
            },
            set: val => {
                // Determine if the column is in the sort priority array
                let fieldHasPriority = constraints.active.sort.priority.includes(props.field);
                // If the column does not have a sort direction and is in the sort priority array
                if (val === null && fieldHasPriority) {
                    // Remove the column from the sort priority array
                    constraints.active.sort.priority.splice(
                        constraints.active.sort.priority.indexOf(props.field), 1
                    );
                }
                // If the column does have a sort direction and is not in the sort priority array
                if (val !== null && !fieldHasPriority) {
                    // Add the column to the sort priority array
                    constraints.active.sort.priority.push(props.field);
                }
            }
        });

        // Define function to toggle the columns sort direction
        const toggleDirection = () => {
            if (direction.value === null) {
                direction.value = priority.value = 'ASC';
            }
            else if (direction.value === 'ASC') {
                direction.value = priority.value = 'DESC';
            }
            else {
                direction.value = priority.value = null;
            }
        };

        // Declare computed variable to determine the cells visibility
        const isVisible = computed(() => {
            return props.field
                ? constraints.active.display.column[props.field].value
                : true;
        });

        return {
            direction,
            priority,
            toggleDirection,
            isVisible,
        };
    },
}
</script>

<style scoped>

</style>
