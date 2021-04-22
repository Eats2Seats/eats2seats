<template>
    <card>
<!--        <template #header>-->
<!--            <div class="flex flex-col">-->
<!--                <p class="font-serif font-bold text-gray-700 text-lg">-->
<!--                    Event Summary-->
<!--                </p>-->
<!--            </div>-->
<!--        </template>-->
<!--        <template #body>-->
<!--            <div class="flex-col divide-y divide-gray-300 space-y-4">-->
<!--                <div class="flex flex-col px-6">-->
<!--                    <p-->
<!--                        class="font-serif font-regular text-gray-500 text-sm"-->
<!--                    >-->
<!--                        Attendance-->
<!--                    </p>-->
<!--                    <p-->
<!--                        class="mt-2 font-serif font-regular text-gray-700 text-base"-->
<!--                    >-->
<!--                        <slot name="attendance">-->
<!--                            {{ getAttendence() }}-->
<!--                        </slot>-->
<!--                    </p>-->
<!--                </div>-->
<!--                <div class="flex flex-col px-6">-->
<!--                    <p-->
<!--                        class="mt-4 font-serif font-regular text-gray-500 text-sm"-->
<!--                    >-->
<!--                        <slot name="earningsName"> Earnings </slot>-->
<!--                    </p>-->
<!--                    <p-->
<!--                        class="mt-2 font-serif font-regular text-gray-700 text-base"-->
<!--                    >-->
<!--                        <slot name="earnings"> ${{ earnings }} </slot>-->
<!--                    </p>-->
<!--                </div>-->
<!--                <div class="flex flex-col px-6">-->
<!--                    <p-->
<!--                        class="mt-4 font-serif font-regular text-gray-500 text-sm"-->
<!--                    >-->
<!--                        Feedback-->
<!--                    </p>-->
<!--                    <p-->
<!--                        class="mt-2 font-serif font-regular text-gray-700 text-base"-->
<!--                    >-->
<!--                        <slot name="feedback">-->
<!--                            <div class="flex justify-between">-->
<!--                                <div>-->
<!--                                <span v-for="i in this.feedback">-->
<!--                                    <svg-->
<!--                                        class="inline h-4 w-4 text-indigo-600"-->
<!--                                        xmlns="http://www.w3.org/2000/svg"-->
<!--                                        viewBox="0 0 20 20"-->
<!--                                        fill="currentColor"-->
<!--                                    >-->
<!--                                        <path-->
<!--                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"-->
<!--                                        />-->
<!--                                    </svg>-->
<!--                                </span>-->

<!--                                <span v-for="i in（5-this.feedback)">-->
<!--                                    <svg-->
<!--                                        class="inline h-4 w-4 text-gray-500"-->
<!--                                        xmlns="http://www.w3.org/2000/svg"-->
<!--                                        viewBox="0 0 20 20"-->
<!--                                        fill="currentColor"-->
<!--                                    >-->
<!--                                        <path-->
<!--                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"-->
<!--                                        />-->
<!--                                    </svg>-->
<!--                                </span>-->
<!--                                </div>-->

<!--                                <svg-->
<!--                                    class="h-6 w-6 text-gray-400"-->
<!--                                    xmlns="http://www.w3.org/2000/svg"-->
<!--                                    fill="none"-->
<!--                                    viewBox="0 0 24 24"-->
<!--                                    stroke="currentColor"-->
<!--                                >-->
<!--                                    <path-->
<!--                                        stroke-linecap="round"-->
<!--                                        stroke-linejoin="round"-->
<!--                                        stroke-width="2"-->
<!--                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"-->
<!--                                    />-->
<!--                                </svg>-->

<!--                            </div>-->
<!--                        </slot>-->
<!--                    </p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </template>-->
    </card>
</template>

<script>
import Card from "@/Components/Card";
export default {
    name: "EventSummaryCard",
    components: {
        Card,
    },
    data() {
        return {
            attendance: true,
            earnings: 5230,
            feedback: 4,
        };
    },
    methods: {
        getAttendence() {
            return this.attendance ? "Present" : "Absent";
        },
    },
};
</script>

