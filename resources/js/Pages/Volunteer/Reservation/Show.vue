<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <event-card
            :event="event"
            :venue="venue"
        />
        <stand-card
            :reservation="reservation"
        />
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import EventCard from "@/Components/EventCard"
import StandCard from "@/Components/StandCard"

export default {
    name: 'Show',
    components: {
        VolunteerLayout,
        EventCard,
        StandCard,
    },
    props: {
        event: {
            required: true,
            type: Object,
        },
        venue: {
            required: true,
            type: Object,
        },
        reservation: {
            required: true,
            type: Object,
        }
    },
    data () {
        return {
            breadcrumbs: [
                { name: 'Reservations', url: '/volunteer/reservations' },
                { name: 'Reservation', url: window.location.pathname },
            ],
        }
    },
}
</script>

<style scoped>

</style>
