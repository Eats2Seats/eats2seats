<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <event-details-card
            :event="event"
            :venue="venue"
        />
        <stand-details-card
            :reservation="reservation"
        />
        <cancel-reservation-card
            :reservation="reservation"
        />
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import EventDetailsCard from "@/Components/Volunteer/Event/Show/EventDetailsCard";
import StandDetailsCard from "@/Components/Volunteer/Reservation/Show/StandDetailsCard";
import CancelReservationCard from "@/Components/Volunteer/Reservation/Show/CancelReservationCard";
export default {
    name: 'Show',
    components: {
        VolunteerLayout,
        EventDetailsCard,
        StandDetailsCard,
        CancelReservationCard,
    },
    props: {
        event: Object,
        venue: Object,
        reservation: Object,
    },
    data () {
        return {
            breadcrumbs: [
                { name: 'Reservation', url: '/volunteer/reservations' },
                { name: 'Reservation', url: window.location.pathname },
            ],
        }
    },
}
</script>

<style scoped>

</style>
