<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <confirm-registration-card
            :event="event"
            :venue="venue"
            :reservation="reservation"
        />
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import ConfirmRegistrationCard from "@/Components/Pages/Volunteer/Reservation/Edit/ConfirmRegistrationCard";

export default {
    name: 'Edit',
    components: {
        VolunteerLayout,
        ConfirmRegistrationCard,
    },
    props: {
        event: Object,
        venue: Object,
        reservation: Object,
    },
    data() {
        return {
            breadcrumbs: [
                { name: 'Events', url: '/volunteer/events' },
                { name: 'Event', url: `/volunteer/events/${this.$props.event.id}` },
                { name: 'Register', url: window.location.pathname },
            ],
        }
    },
}
</script>

<style scoped>

</style>
