<template>
    <Menu as="div" class="relative inline-block">
        <MenuButton class="inline-flex justify-center items-center w-full h-full space-x-2 rounded-md border border-gray-200 px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 shadow-sm">
            <eye-icon class="h-5 w-5 text-gray-500"/>
        </MenuButton>
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <MenuItems class="origin-bottom-left absolute w-56 left-0 bottom-0 bg-white mb-14 rounded shadow-lg divide-y divide-gray-200 ring-1 ring-black ring-opacity-5 focus:outline-none">
                <slot></slot>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
import {EyeIcon} from "@heroicons/vue/outline";
import {Menu, MenuButton, MenuItems} from "@headlessui/vue";

export default {
    name: 'MatrixColumnVisibility',
    components: {Menu, MenuButton, MenuItems, EyeIcon},
    props: {},
    setup(props, context) {

        return {};
    },
}
</script>

<style scoped>

</style>
