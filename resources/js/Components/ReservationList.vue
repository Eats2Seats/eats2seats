<template>
    <x-card>
        <x-title>
            My Reservations
        </x-title>
        <x-subtitle>
            View all past, present, and future events that you've committed to attending.
        </x-subtitle>
        <div class="mt-6 flex bg-white space-x-4">
            <input class="w-full py-2 px-4 rounded border border-gray-200" type="text" placeholder="Search">
            <button class="p-2 px-4 bg-white border border-gray-200 rounded group hover:border-indigo-600">
                <search-icon class="h-5 w-5 text-gray-500 group-hover:text-indigo-600"/>
            </button>
        </div>
        <div
            v-for="reservation in $props.reservations"
            :key="reservation.id"
        >
            <x-divider/>
            <inertia-link
                class="flex flex-row justify-between items-center"
                :href="reservationURL(reservation.id)"
            >
                <div class="">
                    <x-text>
                        {{ reservation.event_title }}
                    </x-text>
                    <x-label>
                        {{ formatDate(reservation.event_date) }}
                    </x-label>
                </div>
                <div class="">
                    <chevron-right-icon class="h-5 w-5 text-gray-500"/>
                </div>
            </inertia-link>
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
import { MapIcon, ChevronRightIcon, SearchIcon } from "@heroicons/vue/outline";
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
        ChevronRightIcon,
        SearchIcon
    },
    props: {
        reservations: {
            required: true,
            type: Array,
            validator: (reservations) => reservations.every((reservation) => {
                return typeof reservation === 'object'
                    && typeof reservation['event_title'] === 'string'
                    && !isNaN(Date.parse(reservation['event_date']))
                    && typeof reservation['venue_name'] === 'string'
                    && typeof reservation['position_type'] === 'string';
            })
        }
    },
    methods: {
        reservationURL(id) {
            return '/volunteer/reservations/' + id;
        },
        formatDate(rawDate) {
            let dateObj = new Date(rawDate);
            return dateObj.toLocaleDateString('en-US', {
                day: 'numeric',
                weekday: 'short',
                month: 'long',
                ...(new Date().getFullYear() !== dateObj.getFullYear() && { year: 'numeric'}),
            });
        },
    },
}
</script>

<style scoped>

</style>
