<template>
    <card>
        <template #header>
            <div class="flex justify-between">
                <div>
                    <p class="font-serif font-bold text-gray-700 text-lg">
                        <slot name="upcoming-registered-event-name">{{ event.name }}</slot>
                    </p>
                </div>
                <div>
                    <a href="#">
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
                    </a>
                </div>
            </div>
        </template>
        <template #body>
            <div class="flex-col divide-y divide-gray-300 space-y-4">
                <div class="flex flex-col px-6">
                    <p
                        class="font-serif font-regular text-gray-500 text-sm"
                    >
                        <p> Location </p>
                    </p>
                    <p
                        class="mt-2 font-serif font-regular text-gray-700 text-base"
                    >
                        <slot name="upcoming-event-location">
                            {{ event.location }}
                        </slot>
                    </p>
                </div>
                <div class="flex flex-col px-6">
                    <div class="flex justify-between">
                        <div>
                            <p
                                class="mt-4 font-serif font-regular text-gray-500 text-sm"
                            >
                                <p> Date </p>
                            </p>
                            <p
                                class="mt-2 font-serif font-regular text-gray-700 text-base"
                            >
                                <slot name="upcoming-event-date">
                                    {{ getDate() }}
                                </slot>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col px-6">
                    <p
                        class="mt-4 font-serif font-regular text-gray-500 text-sm"
                    >
                        <p> Time </p>
                    </p>
                    <p
                        class="mt-2 font-serif font-regular text-gray-700 text-base"
                    >
                        <slot name="upcoming-event-positions">
                            {{ getTime() }}
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
    name: "UpcomingEventCard",
    components:{
        Card,
    },
    data () {
        return {
            event: {
                name: 'Princeton vs Georgia Tech',
                location: 'Fred Yager Stadium',
                start: '2021-04-05 17:00:00',
                end: '2021-04-05 20:30:00',
            }
        }
    },
    methods:{
        getDate() {
            // 2021-04-05 -> 2021/04/05
            var modifiedDate = this.event.start
                .split(" ")[0]
                .split("-")
                .join("/");
            // Mon Apr 05 2021 00:00:00 GMT-0700 (Pacific Daylight Time)
            var date = new Date(modifiedDate);

            return (
                date.toString("MMMM").split(" ")[1] +
                " " +
                date.toString("MMMM").split(" ")[2]
            );
        },
         getTime() {
            var startTime = this.event.start.split(" ")[1].split(":");
            startTime =
                startTime[0] > 12
                    ? String(startTime[0] - 12) + ":" + String(startTime[1]) + " pm"
                    : String(startTime[0]) + ":" + String(startTime[1]) + " am";
            var endTime = this.event.end.split(" ")[1].split(":");
            endTime =
                endTime[0] > 12
                    ? String(endTime[0] - 12) + ":" + String(endTime[1]) + " pm"
                    : String(endTime[0]) + ":" + String(endTime[1]) + " am";

            return startTime + " to " + endTime;
        },
    }
}
</script>

<style scoped>

</style>
