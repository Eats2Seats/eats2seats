<template>
    <x-card>
        <x-title>
            Next Event
        </x-title>
        <x-subtitle>
            View details for the next upcoming event with remaining staffing positions.
        </x-subtitle>
        <x-divider/>
        <event-details
            :event="event"
            :venue="venue"
        />
        <x-divider/>
        <inertia-link :href="route('volunteer.events.show', { id: event.id })">
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
import EventDetails from "@/Components/Pages/Volunteer/Event/EventDetails";

export default {
    name: 'NextEventCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XDivider,
        XButton,
        EventDetails,
    },
    props: {
        event: {
            type: Object,
            required: true,
        },
        venue: {
            type: Object,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
