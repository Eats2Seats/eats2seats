<template>
    <div class="flex flex-row items-center justify-between">
        <x-icon-button
            class="disabled:bg-gray-50 group"
            v-on:click="getPrevPage"
            :disabled="list.items.current_page === 1"
        >
            <arrow-narrow-left-icon class="h-5 w-5 text-gray-500 group-disabled:text-gray-300"/>
        </x-icon-button>
        <x-text>
            {{ list.items.from ? list.items.from : 0}} - {{ list.items.to ? list.items.to : 0 }} of {{ list.items.total }}
        </x-text>
        <x-icon-button
            class="disabled:bg-gray-50 group"
            v-on:click="getNextPage"
            :disabled="list.items.current_page === list.items.last_page"
        >
            <arrow-narrow-right-icon class="h-5 w-5 text-gray-500 group-disabled:text-gray-300"/>
        </x-icon-button>
    </div>
</template>

<script>
import XIconButton from "@/Components/General/XIconButton";
import XText from "@/Components/General/XText";
import {ArrowNarrowLeftIcon, ArrowNarrowRightIcon} from "@heroicons/vue/solid/esm";
export default {
    name: 'ListPagination',
    components: {
        XIconButton,
        XText,
        ArrowNarrowLeftIcon,
        ArrowNarrowRightIcon,
    },
    data () {
        return {
            list: this.$parent.$props,
        };
    },
    methods: {
        getPrevPage () {
            this.$inertia.visit(this.list.items.prev_page_url, {
                preserveScroll: true,
                preserveState: true,
            });
        },
        getNextPage () {
            this.$inertia.visit(this.list.items.next_page_url, {
                preserveScroll: true,
                preserveState: true,
            });
        }
    }
}
</script>

<style scoped>

</style>
