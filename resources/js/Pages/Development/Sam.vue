<template>
    <dev-layout class="p-4">
        <div class="flex flex-col min-w-full space-y-9">
            <stand-information-card>
                
            </stand-information-card>
            <next-event-card>

            </next-event-card>
            <manage-registration-card>

            </manage-registration-card>
        </div>
    </dev-layout>
</template>

<script>
import DevLayout from "@/Layouts/DevLayout";
import NavigationActionCard from "@/Components/NavigationActionCard"
import StandInformationCard from "@/Components/StandInformationCard"
import NextEventCard from "@/Components/NextEventCard"
import ManageRegistrationCard from "@/Components/ManageRegistrationCard"
export default {
    components: {
        DevLayout,
        NavigationActionCard,
        StandInformationCard,
        NextEventCard,
        ManageRegistrationCard,
    },
    props: {},
    data () {
        return {

        }
    },
}
</script>
