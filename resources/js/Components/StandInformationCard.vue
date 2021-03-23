<template>
    <card>
        <template #header>
            <div class="flex flex-col">
                <p class="font-serif font-bold text-gray-700 text-lg">
                    <p>Stand Information</p>
                </p>
            </div>
        </template>
        <template #body>
            <div class="flex-col divide-y divide-gray-300 space-y-4">
                <div class="flex flex-col px-6">
                    <p
                        class="font-serif font-regular text-gray-500 text-sm"
                    >
                        <p> Stand Information </p>
                    </p>
                    <p
                        class="mt-2 font-serif font-regular text-gray-700 text-base"
                    >
                        <slot name="standName">
                            {{ name }}
                        </slot>
                    </p>
                </div>
                <div class="flex flex-col px-6">
                    <div class="flex justify-between">
                        <div>
                            <p
                                class="mt-4 font-serif font-regular text-gray-500 text-sm"
                            >
                                <p> Location </p>
                            </p>
                            <p
                                class="mt-2 font-serif font-regular text-gray-700 text-base"
                            >
                                <slot name="standLocation">
                                    {{ location }}
                                </slot>
                            </p>
                        </div>
                        <a href="#">
                            <svg
                                class="mt-6 h-6 w-6 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col px-6">
                    <p
                        class="mt-4 font-serif font-regular text-gray-500 text-sm"
                    >
                        <p> Position </p>
                    </p>
                    <p
                        class="mt-2 font-serif font-regular text-gray-700 text-base"
                    >
                        <slot name="standPosition">
                            {{ position }}
                        </slot>
                    </p>
                </div>
            </div>
        </template>
    </card>
</template>

<script>
import Card from "@/Components/Card";
export default {
    name: "StandInformationCard",
    components: {
        Card,
    },
    data() {
        return {
            name: "Joe's Hot Dogs",
            location: "Stand 13",
            position: "Alcohol Sales",
        };
    },
};
</script>

<style scoped></style>
