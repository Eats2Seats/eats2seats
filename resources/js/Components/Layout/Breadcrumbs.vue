<template>
    <div class="bg-white px-6">
        <div class="container mx-auto space-x-2 py-4 flex flex-row items-center">
            <inertia-link href="/volunteer/dashboard">
                <home-icon class="h-5 w-5 text-gray-500 hover:text-indigo-600"/>
            </inertia-link>
            <div
                class="flex flex-row space-x-2 items-center"
                v-for="breadcrumb in $props.breadcrumbs"
                :key="breadcrumb.url"
            >
                <chevron-right-icon class="h-5 w-5 text-gray-500"/>
                <inertia-link
                    class="font-serif font-bold text-sm text-gray-500 hover:text-indigo-600"
                    :href="breadcrumb.url"
                >
                    {{ breadcrumb.name }}
                </inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
import { HomeIcon, ChevronRightIcon } from '@heroicons/vue/solid';
export default {
    name: 'Breadcrumbs',
    components: {
        HomeIcon,
        ChevronRightIcon,
    },
    props: {
        breadcrumbs: {
            required: true,
            type: Object,
            validator: (breadcrumbs) => breadcrumbs.every((breadcrumb) => {
                return typeof breadcrumb === 'object'
                    && typeof breadcrumb['name'] === 'string'
                    && typeof breadcrumb['url'] === 'string';
            }),
        },
    }
}
</script>

<style scoped>

</style>
