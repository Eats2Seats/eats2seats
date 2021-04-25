<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <next-reservation-card
            :reservation="next"
        />
        <upcoming-reservations-card
            :reservations="reservations"
            :filters="filters"
        />
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import NextReservationCard from "@/Components/Volunteer/Reservation/Index/NextReservationCard";
import UpcomingReservationsCard from "@/Components/Volunteer/Reservation/Index/UpcomingReservationsCard";
export default {
    name: 'Index',
    components: {
        VolunteerLayout,
        NextReservationCard,
        UpcomingReservationsCard,
    },
    props: {
        next: Object,
        reservations: Object,
        filters: Object,
    },
    data () {
        return {
            breadcrumbs: [
                { name: 'Reservation', url: window.location.pathname },
            ],
        }
    },
}
</script>

<style scoped>

</style>
