<template>
    <x-label>
        Title
    </x-label>
    <x-text>
        {{ event.title }}
    </x-text>
    <x-divider/>
    <div class="flex flex-row items-center justify-between">
        <div>
            <x-label>
                Location
            </x-label>
            <x-text>
                {{ venue.name }}
            </x-text>
        </div>
        <div>
            <a
                :href="googleMapsLink"
                target="_blank"
            >
                <x-icon-button>
                    <MapIcon class="h-6 w-6 text-gray-500"/>
                </x-icon-button>
            </a>
        </div>
    </div>
    <x-divider/>
    <x-label>
        Start
    </x-label>
    <x-text>
        {{ formatDate(event.start) }}
    </x-text>
    <x-divider/>
    <x-label>
        End
    </x-label>
    <x-text>
        {{ formatDate(event.end) }}
    </x-text>
</template>

<script>
import XTitle from '@/Components/General/XTitle';
import XSubtitle from '@/Components/General/XSubtitle';
import XDivider from "@/Components/General/XDivider";
import XText from "@/Components/General/XText";
import XLabel from "@/Components/General/XLabel";
import XIconButton from "@/Components/General/XIconButton";
import {MapIcon} from "@heroicons/vue/outline";
export default {
    name: 'ReservationDetails',
    components: {
        XTitle,
        XSubtitle,
        XDivider,
        XText,
        XLabel,
        XIconButton,
        MapIcon,
    },
    props: {
        event: {
            type: Object,
            required: true,
        },
        venue: {
            type: Object,
            required: true,
        }
    },
    computed:{
        googleMapsLink () {
            return `https://www.google.com/maps/place/${this.venue.street}+${this.venue.city}+${this.venue.state}+
            ${this.venue.zip}`.split(' ').join('+');
        },
    },
    methods: {
        formatDate (rawDate) {
            let dateObj = new Date(rawDate);
            let dateStr = dateObj.toLocaleDateString('en-US', {
                day: 'numeric',
                weekday: 'short',
                month: 'long',
                ...(new Date().getFullYear() !== dateObj.getFullYear() && { year: 'numeric'}),
            });
            let timeStr = dateObj.toLocaleTimeString('en-US', {
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
            });
            return `${dateStr} @ ${timeStr}`;
        },
    },
}
</script>

<style scoped>

</style>
