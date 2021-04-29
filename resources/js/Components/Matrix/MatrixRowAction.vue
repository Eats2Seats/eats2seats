<template>
    <Menu as="div" class="relative inline-block">
        <MenuButton class="inline-flex justify-center items-center w-full h-full space-x-2 rounded-md border border-gray-200 px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 shadow-sm">
            <p class="text-sm font-bold">Actions</p>
            <selector-icon class="h-5 w-5 text-gray-500"/>
        </MenuButton>
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <MenuItems class="origin-top-right absolute w-56 right-0 bg-white mt-4 border border-gray-200 rounded shadow-lg divide-y divide-gray-200 ring-1 ring-black ring-opacity-5 focus:outline-none">
                <slot :executeAction="executeAction"></slot>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
import {inject} from "vue";
import {Menu, MenuButton, MenuItems} from "@headlessui/vue";
import {SelectorIcon} from "@heroicons/vue/outline/esm";

export default {
    name: 'MatrixRowAction',
    components: {Menu, MenuButton, MenuItems, SelectorIcon},
    props: {},
    setup(props, context) {
        // Inject matrix state
        const selectedRows = inject('selected-rows');

        // Define function to execute row action functions provided by children
        const executeAction = (action) => {
            action(selectedRows.value);
        };

        return {
            executeAction
        };
    },
}
</script>

<style scoped>

</style>
