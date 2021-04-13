<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <next-reservation :next="next"/>
        <reservation-list :reservations="reservations"/>
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import NextReservation from "@/Components/NextReservationCard"
import ReservationList from "@/Components/ReservationList"
export default {
    name: 'Index',
    components: {
        VolunteerLayout,
        NextReservation,
        ReservationList,
    },
    props: {
        next: {
            required: true,
            type: Object,
        },
        reservations: {
            required: true,
            type: Array,
        }
    },
    data () {
        return {
            breadcrumbs: [
                { name: 'Reservations', url: window.location.pathname },
            ],
        }
    }
}
</script>

<style scoped>

</style>
