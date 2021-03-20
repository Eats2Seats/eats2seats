<template>
    <card>
        <template #header>
            <div class="flex flex-col">
                <p class="mt-4 font-serif font-bold text-gray-700 text-lg">
                    <slot name>Stand Information</slot>
                </p>
            </div>
        </template>
        <template #body>
            <div class="flex-col divide-y-2">
                <div class="flex flex-col">
                    <p
                        class="mt-4 font-serif font-regular text-gray-500 text-sm"
                    >
                        <slot> Stand Information </slot>
                    </p>
                    <p
                        class="mt-2 font-serif font-regular text-gray-700 text-base"
                    >
                        <slot name="standName">
                            {{ name }}
                        </slot>
                    </p>
                </div>
                <div class="flex flex-col">
                    <div class="flex justify-between">
                        <div>
                            <p
                                class="mt-4 font-serif font-regular text-gray-500 text-sm"
                            >
                                <slot name> Location </slot>
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
                <div class="flex flex-col">
                    <p
                        class="mt-4 font-serif font-regular text-gray-500 text-sm"
                    >
                        <slot> Position </slot>
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
