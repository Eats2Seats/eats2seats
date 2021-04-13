<template>
    <inertia-link
        class="flex px-6 py-4 justify-start items-center group hover:bg-indigo-600 transition"
        :href="href"
    >
        <x-text class="text-xl group-hover:text-white">
            <slot></slot>
        </x-text>
    </inertia-link>
</template>

<script>
import XText from "@/Components/Text";
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
        }
    },
}
</script>

<style scoped>

</style>
