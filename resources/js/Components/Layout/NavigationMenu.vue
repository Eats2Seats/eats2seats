<template>
    <nav
        class="fixed inset-0 overflow-hidden duration-500 z-50"
        :class="showNav ? 'visible' : 'invisible'"
        aria-labelledby="nav-menu-title"
        role="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity ease-in-out duration-500"
                :class="showNav ? 'opacity-100' : 'opacity-0'"
                aria-hidden="true"
            ></div>
            <div class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                <div
                    class="relative w-screen max-w-md transform transition ease-in-out duration-500 sm:duration-700"
                    :class="showNav ? 'translate-x-0' : 'translate-x-full'"
                >
                    <div
                        class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4 ease-in-out duration-500"
                        :class="showNav ? 'opacity-100' : 'opacity-0'"
                    ></div>
                    <div class="h-full flex flex-col pt-6 bg-white shadow-xl overflow-y-scroll">
                        <div class="flex flex-row items-center justify-between px-6">
                            <x-title id="nav-menu-title">
                                Navigation
                            </x-title>
                            <x-icon-button
                                class="bg-white border-indigo-600 group hover:bg-indigo-600 transition"
                                v-on:click="toggleNav"
                            >
                                <span class="sr-only">Close navigation menu</span>
                                <x-icon
                                    class="h-5 w-5 text-indigo-600 group-hover:text-white"
                                    aria-hidden="true"
                                />
                            </x-icon-button>
                        </div>
                        <div class="mt-6 relative flex flex-col divide-y border-t border-b border-gray-200 transition">
                            <slot></slot>
                        </div>
                        <div class="flex-1 flex-row"></div>
                        <x-navigation-menu-item
                            class="border-t border-gray-200 hover:bg-gray-50"
                            href=""
                        >
                            <span class="text-gray-700 group-hover:text-gray-700">
                                Sign Out
                            </span>
                        </x-navigation-menu-item>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import XTitle from "@/Components/General/XTitle";
import XIconButton from "@/Components/General/XIconButton";
import { XIcon } from "@heroicons/vue/solid";
import XNavigationMenuItem from "@/Components/Layout/NavigationMenuItem";
export default {
    name: 'NavigationMenu',
    components: {
        XTitle,
        XIconButton,
        XIcon,
        XNavigationMenuItem
    },
    data () {
        return {
            showNav: false,
        }
    },
    methods: {
        toggleNav() {
            this.showNav = !this.showNav;
        }
    }
}
</script>

<style scoped>

</style>
