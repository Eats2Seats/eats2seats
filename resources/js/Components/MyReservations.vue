<template>
    <x-card>
        <x-title>
            My Reservations
        </x-title>
        <x-subtitle>
            View all past, present, and future events that you've committed to attending.
        </x-subtitle>
        <div class="flex bg-white shadow">
            

            <input class="w-full p-2 rounded" type="text" placeholder="Search">
            <button class="p-2 pl-4 pr-4 text-white bg-indigo-600 rounded hover:bg-indigo-500">
                <p class="text-xs font-semibold">Search</p>
            </button>
        </div>
        <x-divider/>
        <!-- Reservation Cards go here-->
        <inertia-link :href="formAddress(res[0].id)">
            <x-text>
                {{ res[0].event_title }}
            </x-text>
            <x-subtitle>
                {{ getDate(res[0].event_date) }} at {{ getTime(res[0].event_date)}}
            </x-subtitle>
        </inertia-link>
        <x-divider/>

        <inertia-link :href="formAddress(res[1].id)">
            <x-text>
                {{ res[1].event_title }}
            </x-text>
            <x-subtitle>
                {{ getDate(res[1].event_date) }} at {{ getTime(res[1].event_date) }}
            </x-subtitle>
        </inertia-link>
        <x-divider/>

        <inertia-link :href="formAddress(res[2].id)">
            <x-text>
                {{ res[2].event_title }}
            </x-text>
            <x-subtitle>
                {{ getDate(res[2].event_date) }} at {{ getTime(res[2].event_date) }}
            </x-subtitle>
        </inertia-link>
        <x-divider/>

        <inertia-link :href="formAddress(res[3].id)">
            <x-text>
                {{ res[3].event_title }}
            </x-text>
            <x-subtitle>
                {{ getDate(res[3].event_date) }} at {{getTime(res[3].event_date)}}
            </x-subtitle>
        </inertia-link>
        <x-divider/>
        <!-- Nav Bar-->
        <div class="flex justify-between">
            <div class="">
                <x-icon-button>
                    <ArrowLeftIcon class="w-6 h-6 text-grey-500"/>
                </x-icon-button>
            </div>
            <div class="">
                <!-- Enter pageination info here. Will be calculated later-->
                1-4 of 6
            </div>
            <div class="">
                <x-icon-button>
                    <ArrowRightIcon class="w-6 h-6 text-grey-500"/>
                </x-icon-button>
            </div>
        </div>
    </x-card>
</template>

<script>
import XCard from "@/Components/Card";
import XTitle from "@/Components/Title";
import XSubtitle from "@/Components/Subtitle";
import XLabel from "@/Components/Label";
import XText from "@/Components/Text";
import XDivider from "@/Components/Divider";
import XButton from "@/Components/Button";
import XIconButton from "@/Components/IconButton";
import { MapIcon } from "@heroicons/vue/outline"
import { ArrowLeftIcon } from "@heroicons/vue/outline"
import { ArrowRightIcon } from "@heroicons/vue/outline"
export default {
    name: 'NextEvent',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XLabel,
        XText,
        XDivider,
        XButton,
        XIconButton,
        MapIcon,
        ArrowLeftIcon,
        ArrowRightIcon
    },
    props: {
        res: Object,
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
        formAddress(id){
            return "/volunteer/reservations/" + id
        },
    },
    data() {
        return {

        }
    },
}
</script>

<style scoped>

</style>
