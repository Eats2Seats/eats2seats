<template>
    <x-icon-button
        class="px-4"
        v-on:click="$refs['filter-menu'].toggleMenu()"
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
                <x-button
                    v-on:click="applyFilters"
                >
                    Apply Filters
                </x-button>
                <x-button
                    v-on:click="clearFilters"
                    class="!text-gray-500 !border-gray-400 hover:!bg-gray-500 hover:!text-white"
                >
                    Clear Filters
                </x-button>
            </div>
        </template>
    </x-slide-out-menu>
</template>

<script>
import XIconButton from "@/Components/IconButton";
import XSlideOutMenu from "@/Components/SlideOutMenu";
import XButton from "@/Components/Button";
import {FilterIcon} from "@heroicons/vue/solid";
export default {
    name: 'ListFilterMenu',
    components: {
        XIconButton,
        XSlideOutMenu,
        XButton,
        FilterIcon
    },
    emits: [
        'filter-apply',
        'filter-clear',
    ],
    mounted () {
        this.emitter.on('filter-update', e => this.filtersChanged = true);
    },
    methods: {
        applyFilters () {
            this.emitter.emit('filter-apply');
            this.$refs["filter-menu"].toggleMenu();
        },
        clearFilters () {
            this.emitter.emit('filter-clear');
            this.emitter.emit('filter-apply');
        }
    }
}
</script>

<style scoped>

</style>
