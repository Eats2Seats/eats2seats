<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <next-event-card
            :event="next"
            :venue="next.venue"
        />
        <upcoming-events-card
            :events="events"
            :filters="filters"
        />
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import NextEventCard from "@/Components/Volunteer/Event/Index/NextEventCard";
import UpcomingEventsCard from "@/Components/Volunteer/Event/Index/UpcomingEventsCard";
export default {
    name: 'Index',
    components: {
        VolunteerLayout,
        NextEventCard,
        UpcomingEventsCard,
    },
    props: {
        next: Object,
        events: Array,
        filters: Object,
    },
    data () {
        return {
            breadcrumbs: [
                { name: 'Events', url: window.location.pathname },
            ],
        }
    },
}
</script>

<style scoped>

</style>
