<template>
    <x-card>
        <x-title>
            Next Reservation
        </x-title>
        <x-subtitle>
            View details for the next event you're scheduled to attend.
        </x-subtitle>
        <x-divider/>
        <reservation-details
            :event="reservation.event"
            :venue="reservation.venue"
        />
        <x-divider/>
        <inertia-link :href="route('volunteer.reservations.show', { id: reservation.id })" >
            <x-button>
                View More Details
            </x-button>
        </inertia-link>
    </x-card>
</template>

<script>
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XSubtitle from "@/Components/General/XSubtitle";
import XDivider from "@/Components/General/XDivider";
import XButton from "@/Components/General/XButton";
import ReservationDetails from "@/Components/Pages/Volunteer/Reservation/ReservationDetails";

export default {
    name: 'NextReservationCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XDivider,
        XButton,
        ReservationDetails,
    },
    props: {
        reservation: {
            type: Object,
            required: true,
        },
    }
}
</script>

<style scoped>

</style>
