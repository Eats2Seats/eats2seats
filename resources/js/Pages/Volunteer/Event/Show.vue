<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <x-title>
                Event
            </x-title>
            <x-subtitle class="mt-3">
                View details about this upcoming event.
            </x-subtitle>
            <x-divider/>
            <x-label>Title</x-label>
            <x-text>{{event.title}}</x-text>
            <x-divider/>
            <div class="flex flex-row items-center">
                <div class="flex-1 flex flex-col">
                    <x-label>Location</x-label>
                    <x-text>{{venue.name}}</x-text>
                </div>
                <div class="ml-6">
                    <a href="#">
                        <x-icon-button>
                            <MapIcon class="h-6 w-6 text-gray-500"/>
                        </x-icon-button>
                    </a>
                </div>
            </div>
            <x-divider/>
            <x-label>Start</x-label>
            <x-text>{{transferToStringDate(event.start)}}</x-text>
            <x-divider/>
            <x-label>End</x-label>
            <x-text>{{transferToStringDate(event.end)}}</x-text>
        </x-card>
      <x-card class="mt-8">
            <x-title>
                Positions
            </x-title>
            <x-subtitle class="mt-3">
                View all staffing positions that are available to reserve.
            </x-subtitle>
            <hr class="-mx-6 mt-6 bg-gray-200">
            <div class="-mx-6 bg-gray-50">
                <h2 class="ml-6 py-4 font-serif font-bold text-lg text-gray-700"> Position Options</h2>
            </div>
            <hr class="-mx-6 mb-6 bg-gray-200">
            <x-label>
                Affiliation
            </x-label>
            <div class="mb-4 flex-1 flex flex-col">
                <select class="h-10 border border-gray-300 placeholder-gray-500" name="" id="">
                <option value="Independent">Independent</option>
            </select>
            </div>
            <x-label>
                Position Type
            </x-label>
            <div class="mb-4 flex-1 flex flex-col">
                <select class="h-10 border border-gray-300" v-model="position">
                    <!-- initial value of v-model have to match the value of the disabled one -->
                    <option value="" selected disabled hidden>
                       Select Your Position
                    </option>
                    <option v-for="po in positionOptions" :key="po">{{po}}</option>
                </select>
            </div>
            <hr class="-mx-6 mt-6 bg-gray-200">
            <div class="-mx-6 bg-gray-50">
                <h2 class="ml-6 py-4 font-serif font-bold text-lg text-gray-700"> Available Positions</h2>
            </div>
            <hr class="-mx-6 mb-6 bg-gray-200">

            <div v-for="(val, key, index) in filterReservationsByPosition" :key="key">
                <div class="flex flex-row items-center">
                    <div  class="flex-1 flex flex-col">
                        <x-text>{{key}}</x-text>
                        <x-label>{{val}} Positions Remaining</x-label>
                    </div>
                    <div class="ml-6">
                        <inertia-link href= "#" >
                            <button class="p-2">
                            <ChevronRightIcon class="h-6 w-6 text-gray-500"/>
                            </button>
                        </inertia-link>
                    </div>

                </div>
                <!-- avoid the divider for the last row -->
                <x-divider v-if="index < Object.keys(filterReservationsByPosition).length - 1"/>
            </div>



      </x-card>
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import XCard from "@/Components/Card";
import XTitle from "@/Components/Title";
import XSubtitle from "@/Components/Subtitle";
import XLabel from "@/Components/Label";
import XText from "@/Components/Text";
import XDivider from "@/Components/Divider";
import XButton from "@/Components/Button";
import XIconButton from "@/Components/IconButton";
import { MapIcon } from "@heroicons/vue/outline";
import { ChevronRightIcon } from "@heroicons/vue/outline";
import { SearchIcon } from "@heroicons/vue/outline";
export default {
    name: 'Show',
    components: {
        VolunteerLayout,
        XCard,
        XTitle,
        XSubtitle,
        XLabel,
        XText,
        XDivider,
        XButton,
        XIconButton,
        MapIcon,
        ChevronRightIcon,
        SearchIcon,
    },
    data() {
        return {
            position: "",
            breadcrumbs: [
                { name: 'Events', url: '/volunteer/events' },
                { name: 'Event', url: window.location.pathname },
            ],
        }
    },
    computed:{
        positionOptions(){
            // '...' -> convert a set to array
            return [...new Set(this.reservations.map(res => res.position_type))]
        },
        filterReservationsByPosition(){
            var filtered_reservations
            var d = {}
            if (this.position) {
                filtered_reservations = this.reservations.filter(res => res.position_type == this.position)

                for (let fr of filtered_reservations){
                    // d[fr.position_type]? 1 : d[fr.position_type]+ 1
                    if (d[fr.stand_name]){
                        d[fr.stand_name] += 1
                    }else{
                        d[fr.stand_name] = 1
                    }
                }
            }
            return d

        }
    },
    methods: {
        transferToStringDate(d) {
            //take in a string and transform to Date object
            d = new Date(d)
            //get month in String format
            let mon = new Intl.DateTimeFormat('en', { month: 'long'}).format(d);
            //get date with th/rd/st...
            let day = d.getDate()+(d.getDate() % 10 == 1 && d.getDate() != 11 ? 'st' : (d.getDate() % 10 == 2 && d.getDate() != 12 ? 'nd' : (d.getDate() % 10 == 3 && d.getDate() != 13 ? 'rd' : 'th')))
            //get time with am/pm
            let time = d.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })
            //combine and return
            return mon + " " + day + " @ " + time
        },
    },
    props: {
        event: {
            required: true,
            type: Object,
            validator: (event) => {
                return typeof event['id'] === 'number'
                    && typeof event['title'] === 'string'
                    && !isNaN(Date.parse(event['start']))
                    && !isNaN(Date.parse(event['end']));
            },
        },
        venue: {
            required: true,
            type: Object,
            validator: (venue) => {
                return typeof venue['name'] === 'string'
                    && typeof venue['street'] === 'string'
                    && typeof venue['city'] === 'string'
                    && typeof venue['state'] === 'string'
                    && typeof venue['zip'] === 'string'
            },
        },
        reservations: {
            required: true,
            type: Array,
            validator: (reservations) => reservations.every((reservation) => {
                return typeof reservation === 'object'
                    && typeof reservation['id'] === 'number'
                    && typeof reservation['stand_name'] === 'string'
                    && typeof reservation['position_type'] === 'string'
                    && typeof reservation['location'] === 'string'
            }),
        }
    }
}
</script>

<style scoped>

</style>
