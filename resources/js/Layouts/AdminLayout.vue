<template>
    <x-slide-out-menu ref="navMenu">
        <template #title>
            Navigation Menu
        </template>
        <template #body>
            <nav class="flex-none divide-y border-gray-200 border-b">
                <x-navigation-menu-item :href="route('admin.user-documents.index')">
                    Legal Documents
                </x-navigation-menu-item>
                <x-navigation-menu-item :href="route('admin.venues.index')">
                    Venues
                </x-navigation-menu-item>
                <x-navigation-menu-item :href="route('admin.stands.index')">
                    Stands
                </x-navigation-menu-item>
                <x-navigation-menu-item :href="route('admin.events.index')">
                    Events
                </x-navigation-menu-item>
                <x-navigation-menu-item :href="route('admin.reservations.index')">
                    Reservations
                </x-navigation-menu-item>
            </nav>
            <div class="flex-1"></div>
            <x-navigation-menu-item
                class="border-t border-gray-200"
                href="/logout"
                method="post"
            >
                Sign Out
            </x-navigation-menu-item>
        </template>
    </x-slide-out-menu>
    <div class="flex flex-col w-full min-h-screen">
        <header class="flex-none shadow">
            <div class="flex flex-row justify-between items-center p-6 bg-indigo-600">
                <h1 class="font-serif font-bold text-2xl text-white hover:underline">
                    <inertia-link href="/admin">
                        Eats2Seats | Admin
                    </inertia-link>
                </h1>
                <icon-button
                    class="bg-white group hover:bg-transparent hover:!border-white"
                    v-on:click="$refs.navMenu.toggleMenu()"
                >
                    <menu-alt1-icon class="h-5 w-5 text-indigo-600 group-hover:text-white"/>
                </icon-button>
            </div>
            <x-breadcrumbs :breadcrumbs="breadcrumbs"/>
        </header>

        <main class="flex-1 container mx-auto">
            <slot></slot>
        </main>

        <footer class="flex-none justify-self-end mt-8 md:mt-10 py-12 px-6 bg-indigo-600 text-center">
            <x-text class="text-white">Copyright © 2021 Eats2Seats</x-text>
        </footer>
    </div>
</template>

<script>
import IconButton from "@/Components/General/XIconButton";
import {MenuAlt1Icon} from "@heroicons/vue/solid/esm";
import XText from "@/Components/General/XText";
import XSlideOutMenu from "@/Components/General/SlideOutMenu";
import XNavigationMenuItem from "@/Components/Layout/NavigationMenuItem";
import XBreadcrumbs from "@/Components/Layout/Breadcrumbs";

export default {
    name: 'AdminLayout',
    components: {
        IconButton,
        MenuAlt1Icon,
        XText,
        XSlideOutMenu,
        XNavigationMenuItem,
        XBreadcrumbs,
    },
    props: {
        breadcrumbs: {
            required: true,
            type: Object,
        },
    },
    data() {
        return {};
    },
}
</script>

<style scoped>

</style>
