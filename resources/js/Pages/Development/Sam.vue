<template>
    <next-reservation>
        <template #title>
            UNC Chapel Hill vs Duke
        </template>
        <template #location>
            Dean Smith Center
        </template>
        <template #start>
            March 31st @ 5:00 PM
        </template>
        <template #end>
            March 31st @ 8:00 PM
        </template>
    </next-reservation>

    <my-reservations>
        <template #reservationCards>
            <x-text>
                UNC Chapel Hill vs Duke
            </x-text>
            <x-subtitle>
                March 23rd
            </x-subtitle>
            <x-divider/>

            <x-text>
                UNC Chapel Hill vs Duke
            </x-text>
            <x-subtitle>
                March 23rd
            </x-subtitle>
            <x-divider/>

            <x-text>
                UNC Chapel Hill vs Duke
            </x-text>
            <x-subtitle>
                March 23rd
            </x-subtitle>
            <x-divider/>
        </template>
        <template #pagination>
            <x-subtitle>
                1-4 of 6
            </x-subtitle>
        </template>
    </my-reservations>
</template>

<script>
import XSubtitle from "@/Components/Subtitle"
import XText from "@/Components/Text"
import XDivider from"@/Components/Divider"
import NextReservation from "@/Components/NextReservationCard"
import MyReservations from "@/Components/MyReservations"
export default {
    components: {
        XSubtitle,
        XText,
        XDivider,
        NextReservation,
        MyReservations

    },
    props: {},
    data () {
        return {

        }
    },
}
</script>
