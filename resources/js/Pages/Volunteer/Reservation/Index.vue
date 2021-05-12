<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <next-reservation-card
            v-if="next"
            :reservation="next"
        />
        <div
            v-else
            class="mt-8 p-8 bg-white shadow-md"
        >
            <h2 class="font-sans font-bold text-2xl text-gray-700">
                You haven't signed up for an event yet!
            </h2>
            <p class="mt-4 font-sans font-normal text-base text-gray-700">
                Fortunately, reserving a position at an event is easy:
            </p>
            <ol class="mt-4 ml-4 space-y-4 list-decimal list-outside font-sans font-normal text-base text-gray-700">
                <li>Choose an event near you that works with your schedule.</li>
                <li>Choose an available positions at a stand you'd like to staff.</li>
                <li>Confirm your reservation.</li>
            </ol>
            <p class="mt-6 font-sans font-normal text-base text-gray-700">
                <inertia-link
                    class="text-indigo-600 underline hover:text-indigo-700"
                    :href="route('volunteer.events.index')"
                >
                    View all upcoming events
                </inertia-link>
            </p>
        </div>
        <upcoming-reservations-card
            :reservations="reservations"
            :filters="filters"
        />
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import NextReservationCard from "@/Components/Pages/Volunteer/Reservation/Index/NextReservationCard";
import UpcomingReservationsCard from "@/Components/Pages/Volunteer/Reservation/Index/UpcomingReservationsCard";
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
