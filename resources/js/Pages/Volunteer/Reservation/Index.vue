<template>
    <next-reservation :nextRes="next"/>
    <my-reservations :res="reservations"/>
</template>

<script>
import NextReservation from "@/Components/NextReservationCard"
import MyReservations from "@/Components/MyReservations"

export default {
    name: 'Index',
    components: {
        NextReservation,
        MyReservations,
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
    }
}
</script>

<style scoped>

</style>
