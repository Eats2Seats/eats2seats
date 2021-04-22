<template>
    <div class="flex flex-row items-center justify-between">
        <x-icon-button
            class="px-4 disabled:bg-gray-50 group"
            v-on:click="getPrevPage"
            :disabled="list.current_page === 1"
        >
            <arrow-narrow-left-icon class="h-5 w-5 text-gray-500 group-disabled:text-gray-300"/>
        </x-icon-button>
        <x-text>
            {{ list.from ? list.from : 0}} - {{ list.to ? list.to : 0 }} of {{ list.total }}
        </x-text>
        <x-icon-button
            class="px-4 disabled:bg-gray-50 group"
            v-on:click="getNextPage"
            :disabled="list.current_page === list.last_page"
        >
            <arrow-narrow-right-icon class="h-5 w-5 text-gray-500 group-disabled:text-gray-300"/>
        </x-icon-button>
    </div>
</template>

<script>
import XIconButton from "@/Components/IconButton";
import XText from "@/Components/Text";
import { ArrowNarrowRightIcon, ArrowNarrowLeftIcon } from '@heroicons/vue/solid';
export default {
    name: 'Pagination',
    components: {
        XIconButton,
        XText,
        ArrowNarrowLeftIcon,
        ArrowNarrowRightIcon,
    },
    props: {
        list: Object,
    },
    methods: {
        getPrevPage () {
            this.$inertia.visit(this.list.prev_page_url);
        },
        getNextPage () {
            this.$inertia.visit(this.list.next_page_url);
        }
    }
}
</script>

<style scoped>

</style>
