<template>
    <div>
        <x-icon-button v-on:click="toggleMenu" class="!h-full">
            <filter-icon class="h-5 w-5 text-gray-500"/>
        </x-icon-button>
    </div>
    <x-slide-out-menu ref="filter-menu">
        <template #title>
            Filter Reservations
            <!-- TODO Dynamic Name -->
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
import XIconButton from "@/Components/General/XIconButton";
import XSlideOutMenu from "@/Components/General/SlideOutMenu";
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
