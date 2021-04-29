<template>
    <div>
        <button
            v-on:click="toggleMenu"
            class="inline-flex justify-center items-center w-full h-full space-x-2 rounded-md border border-gray-200 px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 shadow-sm"
        >
            <filter-icon class="h-5 w-5 text-gray-500"/>
        </button>
    </div>
    <x-slide-out-menu ref="menu" :class="`!${marginAdjustment}`">
        <template #title>
            {{ title }}
        </template>
        <template #body>
            <div class="m-6 space-y-6">
                <slot></slot>
            </div>
            <div class="fixed left-0 bottom-0 flex flex-col w-full p-6 space-y-4 border-t border-gray-200">
                <matrix-filter-apply @click="toggleMenu"/>
                <matrix-filter-clear @click="toggleMenu"/>
            </div>
        </template>
    </x-slide-out-menu>
</template>

<script>
import {ref} from 'vue';
import XIconButton from "@/Components/General/XIconButton";
import XSlideOutMenu from "@/Components/General/SlideOutMenu";
import {FilterIcon} from "@heroicons/vue/outline/esm";
import MatrixFilterApply from "@/Components/Matrix/MatrixFilterApply";
import MatrixFilterClear from "@/Components/Matrix/MatrixFilterClear";


export default {
    name: 'MatrixFilterMenu',
    components: {
        MatrixFilterClear,
        MatrixFilterApply,
        XIconButton,
        XSlideOutMenu,
        FilterIcon,
    },
    props: {
        title: {
            type: String,
            required: true,
        },
        marginAdjustment: {
            type: String,
            required: false,
        }
    },
    setup(props, context) {
        // Define reactive variable for storing ref to menu
        const menu = ref(null);

        // Define function to toggle menu
        const toggleMenu = () => {
            menu.value.toggleMenu();
        }
        return {
            menu,
            toggleMenu
        };
    },
}
</script>

<style scoped>

</style>
