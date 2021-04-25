<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <event-details-card
            :event="event"
            :venue="venue"
        />
        <available-positions-card
            :event="event"
            :positions="positions"
            :filters="filters"
        />
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import EventDetailsCard from "@/Components/Volunteer/Event/Show/EventDetailsCard";
import AvailablePositionsCard from "@/Components/Volunteer/Event/Show/AvailablePositionsCard";
export default {
    name: 'Show',
    components: {
        VolunteerLayout,
        EventDetailsCard,
        AvailablePositionsCard,
    },
    props: {
        event: Object,
        venue: Object,
        positions: Array,
        filters: Object,
    },
    data() {
        return {
            breadcrumbs: [
                { name: 'Events', url: '/volunteer/events' },
                { name: 'Event', url: window.location.pathname },
            ],
        }
    },
}
</script>

<style scoped>

</style>
