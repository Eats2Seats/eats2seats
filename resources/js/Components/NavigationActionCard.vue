<template>
    <card>
        <template #body>
            <a
                :href="href"
                class="inline-block"
            >
                <div class="flex flex-col">
                    <div class="flex justify-between">
                        <div
                            class="p-3 rounded shadow"
                            :class="iconBackgroundColor"
                        >
                            <svg
                                class="h-6 w-6"
                                :class="iconTextColor"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <slot name="icon-path"></slot>
                            </svg>

                        </div>
                        <div class="">
                            <svg
                                class="h-6 w-6 transform rotate-45 text-gray-300"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18"
                                />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 font-serif font-bold text-gray-700 text-lg">
                        <slot name="title"></slot>
                    </p>
                    <p class="mt-2 font-serif font-regular text-gray-500 text-base">
                        <slot name="desc"></slot>
                    </p>
                </div>
            </a>
        </template>
    </card>
</template>

<script>
import Card from "@/Components/Card";
export default {
    name: "NavigationActionCard",
    components: {
        Card,
    },
    props: {
        href: {
            type: String,
            required: true,
            default: '#',
        },
        iconTextColor: {
            type: String,
            required: true,
        },
        iconBackgroundColor: {
            type: String,
            required: true,
        },
    }
}
</script>

<style scoped>

</style>
