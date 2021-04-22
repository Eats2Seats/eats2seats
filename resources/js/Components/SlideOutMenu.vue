<template>
    <aside
        class="fixed inset-0 overflow-hidden duration-500 z-50"
        :class="showMenu ? 'visible' : 'invisible'"
        aria-labelledby="menu-title"
        role="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity ease-in-out duration-500"
                :class="showMenu ? 'opacity-100' : 'opacity-0'"
                aria-hidden="true"
            ></div>
            <div class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                <div
                    class="relative w-screen max-w-md transform transition ease-in-out duration-500 sm:duration-700"
                    :class="showMenu ? 'translate-x-0' : 'translate-x-full'"
                >
                    <div
                        class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4 ease-in-out duration-500"
                        :class="showMenu ? 'opacity-100' : 'opacity-0'"
                    ></div>
                    <div class="h-full flex flex-col pt-6 bg-white shadow-xl overflow-y-scroll divide-y border-gray-200">
                        <div class="flex flex-row items-center justify-between px-6">
                            <x-title id="menu-title">
                                <slot name="title"></slot>
                            </x-title>
                            <x-icon-button
                                class="bg-white border-indigo-600 group hover:bg-indigo-600 transition"
                                v-on:click="toggleMenu"
                            >
                                <span class="sr-only">Close menu</span>
                                <x-icon
                                    class="h-5 w-5 text-indigo-600 group-hover:text-white"
                                    aria-hidden="true"
                                />
                            </x-icon-button>
                        </div>
                        <div class="h-full mt-6 relative flex flex-col transition">
                            <slot name="body"></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>

<script>
import XTitle from "@/Components/Title";
import XIconButton from "@/Components/IconButton";
import { XIcon } from '@heroicons/vue/solid'
export default {
    name: 'SlideOutMenu',
    components: {
        XTitle,
        XIconButton,
        XIcon,
    },
    data () {
        return {
            showMenu: false,
        }
    },
    methods: {
        toggleMenu () {
            this.showMenu = !this.showMenu;
        }
    }
}
</script>

<style scoped>

</style>
