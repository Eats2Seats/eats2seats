<template>
    <MenuItem
        as="div"
        class="cursor-pointer hover:bg-gray-50"
        @click="selected = !selected"
        disabled
    >
        <div class="px-4 py-3 flex items-center space-x-3">
            <input
                type="checkbox"
                :id="`${uid}-${field}`"
                :value="field"
                v-model="selected"
            >
            <label :for="`${uid}-${field}`">
                <slot></slot>
            </label>
        </div>
    </MenuItem>
</template>

<script>
import {computed, inject} from "vue";
import {MenuItem} from "@headlessui/vue";

export default {
    name: 'MatrixColumnVisibilityItem',
    components: {MenuItem},
    props: {
        field: {
            type: String,
            required: true,
        }
    },
    setup(props, context) {
        // Inject matrix state
        const uid = inject('uid');
        const constraints = inject('constraints');

        // Define computer getter and setter to control column visibility
        const selected = computed({
            get: () => constraints.active.display.column[props.field].value,
            set: val => constraints.active.display.column[props.field].value = val,
        })

        return {
            uid,
            selected,
        };
    },
}
</script>

<style scoped>

</style>
