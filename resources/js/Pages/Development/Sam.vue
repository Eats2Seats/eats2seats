<template>
    <dev-layout class="p-4">
        <div class="flex flex-col min-w-full space-y-9">
            <stand-information-card>
                
            </stand-information-card>
        </div>
    </dev-layout>
</template>

<script>
import DevLayout from "@/Layouts/DevLayout";
import NavigationActionCard from "@/Components/NavigationActionCard";
import StandInformationCard from "@/Components/StandInformationCard"
export default {
    components: {
        DevLayout,
        NavigationActionCard,
        StandInformationCard,
    },
    props: {},
    data () {
        return {

        }
    },
}
</script>
