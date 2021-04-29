<template>
    <x-card>
        <x-title>
            Event
        </x-title>
        <x-subtitle>
            View details about this upcoming event.
        </x-subtitle>
        <x-divider/>
        <event-details
            :event="event"
            :venue="venue"
        />
    </x-card>
</template>

<script>
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XSubtitle from "@/Components/General/XSubtitle";
import XDivider from "@/Components/General/XDivider";
import EventDetails from "@/Components/Pages/Volunteer/Event/EventDetails";

export default {
    name: 'EventDetailsCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XDivider,
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
