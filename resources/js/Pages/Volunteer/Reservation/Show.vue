<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <x-title>
                Event
            </x-title>
            <x-subtitle>
                View details about this upcoming event.
            </x-subtitle>
            <x-divider/>
            <x-event-details
                :event="event"
                :venue="venue"
            />
        </x-card>
        <x-card>
            <x-title>
                Stand
            </x-title>
            <x-subtitle>
                View details about the concession stand you reserved a position at.
            </x-subtitle>
            <x-divider/>
            <x-label>
                Name
            </x-label>
            <x-text>
                {{ reservation.stand_name }}
            </x-text>
            <x-divider/>
            <div class="flex flex-row items-center justify-between">
                <div>
                    <x-label>
                        Location
                    </x-label>
                    <x-text>
                        {{ reservation.stand_location }}
                    </x-text>
                </div>
                <div>
                    <a
                        href="#"
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
                Position
            </x-label>
            <x-text>
                {{ reservation.position_type }}
            </x-text>
        </x-card>
        <x-card>
            <x-title>
                Cancel
            </x-title>
            <x-subtitle>
                Cancel your reservation if you no longer wish to attend the event.
            </x-subtitle>
            <x-divider/>
            <x-button
                class="text-red-600 border-red-600 hover:bg-red-600"
                v-on:click="cancelReservation"
            >
                Cancel Your Reservation
            </x-button>
        </x-card>
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import XCard from "@/Components/Card";
import XTitle from "@/Components/Title";
import XSubtitle from "@/Components/Subtitle";
import XDivider from "@/Components/Divider";
import XText from "@/Components/Text";
import XLabel from "@/Components/Label";
import XButton from "@/Components/Button";
import XIconButton from "@/Components/IconButton";
import XEventDetails from "@/Components/EventDetails";
import { MapIcon } from '@heroicons/vue/outline';
export default {
    name: 'Show',
    components: {
        VolunteerLayout,
        XCard,
        XTitle,
        XSubtitle,
        XDivider,
        XText,
        XLabel,
        XButton,
        XIconButton,
        XEventDetails,
        MapIcon,
    },
    props: {
        event: Object,
        venue: Object,
        reservation: Object,
    },
    data () {
        return {
            breadcrumbs: [
                { name: 'Reservations', url: '/volunteer/reservations' },
                { name: 'Reservation', url: window.location.pathname },
            ],
        }
    },
    methods: {
        cancelReservation () {
            this.$inertia.delete(this.route('volunteer.reservations.delete', {
                id: this.reservation.id
            }));
        }
    }
}
</script>

<style scoped>

</style>
