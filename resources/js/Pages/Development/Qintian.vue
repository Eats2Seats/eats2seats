<template>
    <dev-layout class="p-4">
        <div class="min-w-full flex flex-col space-y-9">
            <event-details-card>

            </event-details-card>

            <event-summary-card>
                
            </event-summary-card>

            <volunteer-information-card>
                
            </volunteer-information-card>

            <stand-information-card>
            </stand-information-card>

            <upcoming-event-card>
            </upcoming-event-card>

            <upcoming-registered-event-card>
            </upcoming-registered-event-card>

        </div>
    </dev-layout>
</template>

<script>
import DevLayout from "@/Layouts/DevLayout";
import Card from "@/Components/Card";
import EventDetailsCard from "@/Components/EventDetailsCard" 
import EventSummaryCard from '../../Components/EventSummaryCard.vue';
import VolunteerInformationCard from '../../Components/VolunteerInformationCard.vue';
import StandInformationCard from '../../Components/StandInformationCard.vue';
import UpcomingEventCard from '../../Components/UpcomingEventCard.vue';
import UpcomingRegisteredEventCard from '../../Components/UpcomingRegisteredEventCard.vue';
export default {
    components: {
        DevLayout,
        EventDetailsCard,
        Card,
        EventSummaryCard,
        VolunteerInformationCard,
        StandInformationCard,
        UpcomingEventCard,
        UpcomingRegisteredEventCard,
    },
    props: {},
    data() {
        return {

        }
    }
}
</script>
