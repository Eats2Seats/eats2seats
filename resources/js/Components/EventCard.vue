<template>
    <x-card>
        <x-title>
            Event
        </x-title>
        <x-subtitle>
            View details about the event you've committed to attending.
        </x-subtitle>

        <x-divider/>
        <x-label>
            Title
        </x-label>
        <!-- UNC Chapel Hill vs Duke-->
        <x-text>
            {{ $props.event.title }}
        </x-text>
        <x-divider/>
        <div class="flex items-center felx-row">
            <div class="flex flex-col flex-1">
                <x-lable>
                    Location
                </x-lable>
                <!-- Dean Smith Center-->
                <x-text>
                    {{ $props.venue.name }}
                </x-text>
            </div>
            <div class ="ml-6">
                <x-icon-button>
                    <MapIcon class="w-6 h-6 text-gray-500" />
                </x-icon-button>
            </div>
        </div>
        <x-divider/>
        <x-label>
            Start
        </x-label>
        <!-- March 31st @ 5:00 PM-->
        <x-text>
            {{ formatDate($props.event.start) }}
        </x-text>
        <x-divider/>
        <x-label>
            End
        </x-label>
        <!-- March 31st @8:00 PM-->
        <x-text>
            {{ formatDate($props.event.end) }}
        </x-text>
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
    },
    props: {
        event: {
            required: true,
            type: Object,
            validator: (event) => {
                return typeof event['title'] === 'string'
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
                    && typeof venue['zip'] === 'string';
            },
        },
    },
    methods: {
        formatDate(rawDate) {
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
