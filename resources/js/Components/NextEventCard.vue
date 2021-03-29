<template>
    <card>
        <template #header>
            <p class="font-serif text-lg font-bold text-gray-700">
                Event Details
            </p>
        </template>

        <template #body>
            <div class="grid grid-cols-1 divide-y divide-gray-300">
                <!-- Location feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">
                        Location
                    </p>
                    <p class="mt-2 font-serif text-base text-gray-700 font-regular">
                        {{event.title}}
                    </p>
                </div>
                <!-- Date feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">
                        Date
                    </p>
                    <p class="mt-2 font-serif text-base text-gray-700 font-regular">
                        {{getDate(event.start)}}
                    </p>
                </div>
                <!-- Time feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">
                        Time
                    </p>
                    <p class="mt-2 font-serif text-base text-gray-700 font-regular">
                        {{getTime(event.start)}} to {{getTime(event.end)}}
                    </p>
                </div>
            </div>
        </template>
    </card>
</template>

<script>
import Card from "@/Components/Card"
export default {
    name: "NextEventCard",
    components: {
        Card,
    },
    data () {
        return {
            event: {
                id: 19,
                title: 'UNC vs Duke',
                location: 'Dean Smith Center',
                start: '2021-03-23 19:15:00',
                end: '2021-03-23 21:00:00'
            }
        }
    },
    methods: {
        getDate(d) {
            let date = new Date(d)
            return date.toDateString()
        },
        getTime(d){
            let time = new Date(d)
            return time.toLocaleTimeString('en-US', {timeStyle: 'short'})
        },
    },
}
</script>

<style scoped>

</style>
