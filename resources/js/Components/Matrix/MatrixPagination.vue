<template>
    <div class="flex flex-row items-center justify-between">
        <x-icon-button
            class="disabled:bg-gray-50 group bg-white"
            v-on:click="getPrevPage"
            :disabled="matrix.current_page === 1"
        >
            <arrow-narrow-left-icon class="h-5 w-5 text-gray-500 group-disabled:text-gray-300"/>
        </x-icon-button>
        <x-text>
            {{ matrix.from ? matrix.from : 0}} - {{ matrix.to ? matrix.to : 0 }} of {{ matrix.total }}
        </x-text>
        <x-icon-button
            class="disabled:bg-gray-50 group bg-white"
            v-on:click="getNextPage"
            :disabled="matrix.current_page === matrix.last_page"
        >
            <arrow-narrow-right-icon class="h-5 w-5 text-gray-500 group-disabled:text-gray-300"/>
        </x-icon-button>
    </div>
</template>

<script>
import {ArrowNarrowLeftIcon, ArrowNarrowRightIcon} from "@heroicons/vue/outline/esm";
import XIconButton from "@/Components/General/XIconButton";
import XText from "@/Components/General/XText";

const emitter = require('tiny-emitter/instance');

export default {
    name: 'MatrixPagination',
    components: {
        XText,
        XIconButton,
        ArrowNarrowRightIcon,
        ArrowNarrowLeftIcon
    },
    data() {
        return {
            matrix: {
                prev_page_url: null,
                next_page_url: null,
                last_page: null,
                current_page: null,
                from: null,
                to: null,
                total: null,
            }
        };
    },
    mounted () {
        emitter.on('matrix-data-updated', (matrix) => this.matrix = matrix);
    },
    beforeUnmount () {
        emitter.off('matrix-data-updated');
    },
    methods: {
        getPrevPage () {
            this.$inertia.visit(this.matrix.prev_page_url, {
                preserveState: true,
                preserveScroll: true,
            });
        },
        getNextPage () {
            this.$inertia.visit(this.matrix.next_page_url, {
                preserveState: true,
                preserveScroll: true,
            })
        }
    }
}
</script>

<style scoped>

</style>
