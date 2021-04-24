<template>
    <x-icon-button
        class="px-4"
        v-on:click="toggleMenu"
    >
        <filter-icon class="h-4 w-4 text-gray-500"/>
    </x-icon-button>
    <x-slide-out-menu ref="filter-menu">
        <template #title>
            Filter Reservations
        </template>
        <template #body>
            <div class="m-6 space-y-6" ref="test">
                <slot></slot>
            </div>
            <div class="fixed left-0 bottom-0 flex flex-col w-full p-6 space-y-4 border-t border-gray-200">
                <list-filter-apply-button @click="toggleMenu"/>
                <list-filter-clear-button @click="toggleMenu"/>
            </div>
        </template>
    </x-slide-out-menu>
</template>

<script>
import XIconButton from "@/Components/IconButton";
import XSlideOutMenu from "@/Components/SlideOutMenu";
import ListFilterApplyButton from "@/Components/List/ListFilterApplyButton";
import ListFilterClearButton from "@/Components/List/ListFilterClearButton";
import {FilterIcon} from "@heroicons/vue/solid";
const emitter = require('tiny-emitter/instance');

export default {
    name: 'ListFilterMenu',
    components: {
        XIconButton,
        XSlideOutMenu,
        FilterIcon,
        ListFilterApplyButton,
        ListFilterClearButton,
    },
    methods: {
        toggleMenu () {
            this.$refs["filter-menu"].toggleMenu();
        },
    }
}
</script>

<style scoped>

</style>
