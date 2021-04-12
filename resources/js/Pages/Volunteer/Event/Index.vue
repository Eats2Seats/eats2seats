<template>
    <x-card>
        <x-title>
            Next Event
        </x-title>
        <x-subtitle class="mt-3">
            View details for the next upcoming event with reamaining staffing positions.
        </x-subtitle>
        <x-divider/>
        <x-label>Title</x-label>
        <x-text>{{next.event.title}}</x-text>
        <x-divider/>
        <div class="flex flex-row items-center">
            <div class="flex-1 flex flex-col">
                <x-label>Location</x-label>
                <x-text>{{next.venue.name}}</x-text>
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
        <x-text>{{transferToStringDate(next.event.start)}}</x-text>
        <x-divider/>
        <x-label>End</x-label>
        <x-text>{{transferToStringDate(next.event.end)}}</x-text>
        <x-divider/>
        <inertia-link :href= "'/volunteer/events/' + next.id" >
            <x-button>
            View More Details
            </x-button>
        </inertia-link>
    </x-card>

    <x-card class="mt-8">
        <x-title>
            Upcoming Events
        </x-title>
        <x-subtitle class="mt-3">
            View all future events with available staffing positions you can reserve.
        </x-subtitle>
        
        <div class="my-3 flex flex-row items-center">
            
            <searchIcon class="inline mr-2 h-4 w-4 text-gray-500"/>
            
            <div class="w-2/5 mr-4 flex-1 flex flex-col">
                <input class="h-8 border border-gray-300 placeholder-gray-500" type="text" placeholder="search" v-model="search">
            </div>

            <div class="w-2/5 mr-4 flex-1 flex flex-col">
                <Calendar class="h-8 text-gray-500" v-model="filterDate" :showIcon="true" :showButtonBar="true"/>
            </div>
            
            <!-- <input class="h-8 border border-gray-200 text-gray-500" type="date" v-model="filterDate"> -->
            
            <!-- <x-icon-button>
               <FilterIcon class="h-6 w-6 text-gray-500" @click="triggerDate"/>
            </x-icon-button> -->
        </div>
        
        <!-- <h1>{{filterDate}} {{next.event.start}}</h1> -->
        <!-- <datepicker v-model="picked" /> -->
        
        
        <x-divider/>
        <div v-for="event in filteredEvents" :key="event.id">
            <div class="flex flex-row items-center">
                <div class="flex-1 flex flex-col">
                    <x-text>{{event.title}}</x-text>
                    <x-label>{{simplifiedTransferToStringDate(event.start)}}</x-label>
                </div>
                <div class="ml-6">
                    <inertia-link :href= "'/volunteer/events/' + event.id" >
                        <button class="p-2">
                        <ChevronRightIcon class="h-6 w-6 text-gray-500"/>
                        </button>
                    </inertia-link>
                </div>
            </div>
            <x-divider/>
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
import { MapIcon } from "@heroicons/vue/outline";
import { ChevronRightIcon } from "@heroicons/vue/outline";
import { SearchIcon } from "@heroicons/vue/outline";
import { FilterIcon } from "@heroicons/vue/solid";
// import Datepicker from 'vue3-datepicker';
import Calendar from 'primevue/calendar';

export default {
    name: 'Index',
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
        ChevronRightIcon,
        SearchIcon,
        FilterIcon,
        Calendar,
    },
    data(){
        return{
            search: "",
            filterDate: "",
            picked: "",
            value: "",
        }
    },
    computed:{
        //Filter events accoring to title/date
        filteredEvents(){
            var f_events = this.events
            if (this.search) {
                f_events = this.events.filter(event => event.title.toLowerCase().includes(this.search.toLowerCase()));
            }
            // if (this.filterDate){
            //     var d1 = new Date(this.filterDate)
            //     console.log(d1)
            //     f_events = f_events.filter(event => event.start.split(" ")[0] == this.filterDate );
            // }
            if (this.filterDate){
                f_events = f_events.filter(event => event.start.split(" ")[0] == this.filterDate.toISOString().split("T")[0] );
            }
            return f_events;
        },

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
        simplifiedTransferToStringDate(d){
            //take in a string and transform to Date object
            d = new Date(d)
            //get month in String format 
            let mon = new Intl.DateTimeFormat('en', { month: 'long'}).format(d);
            //get date with th/rd/st...
            let day = d.getDate()+(d.getDate() % 10 == 1 && d.getDate() != 11 ? 'st' : (d.getDate() % 10 == 2 && d.getDate() != 12 ? 'nd' : (d.getDate() % 10 == 3 && d.getDate() != 13 ? 'rd' : 'th')))
            //combine and return 
            return mon + " " + day 
        }
    },
    props: {
        next: {
            required: true,
            type: Object,
            validator: (next) => {
                return typeof next['event'] === 'object'
                    && typeof next['event']['title'] === 'string'
                    && !isNaN(Date.parse(next['event']['start']))
                    && !isNaN(Date.parse(next['event']['end']))
                    && typeof next['venue'] === 'object'
                    && typeof next['venue']['name'] === 'string'
                    && typeof next['venue']['street'] === 'string'
                    && typeof next['venue']['city'] === 'string'
                    && typeof next['venue']['state'] === 'string'
                    && typeof next['venue']['zip'] === 'string'
            },
        },
        events: {
            required: true,
            type: Array,
            validator: (events) => events.every((event) => {
                return typeof event === 'object'
                    && typeof event['id'] === 'number'
                    && typeof event['title'] === 'string'
                    && !isNaN(Date.parse(event['start']))
                    && !isNaN(Date.parse(event['end']));
            }),
        }
    }
}
</script>

<style scoped>

</style>
