<template>
    <inertia-link
        class="flex px-6 py-4 justify-start items-center group hover:bg-indigo-600 transition"
        :href="href"
        :method="method"
    >
        <x-text class="text-xl group-hover:text-white">
            <slot></slot>
        </x-text>
    </inertia-link>
</template>

<script>
import XText from "@/Components/General/XText";
export default {
    name: 'NavigationMenuItem',
    components: {
        XText,
    },
    props: {
        href: {
            required: true,
            type: String,
            default: '#',
        },
        method: {
            type: String,
            required: false,
            default: 'get'
        }
    },
}
</script>

<style scoped>

</style>
