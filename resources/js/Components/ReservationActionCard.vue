<template>
    <x-card>
        <x-title>
            Actions
        </x-title>
        <x-subtitle>
            Manage your reservation using the available actions.
        </x-subtitle>
        <x-divider/>

        <button v-on:click="cancelReservation" class="w-full py-3 text-center text-red-600 border border-red-600 rounded hover:bg-red-600 hover:text-white">
            Cancel Reservation
        </button>
    </x-card>
</template>

<script>
import XCard from "@/Components/Card";
import XTitle from "@/Components/Title";
import XSubtitle from "@/Components/Subtitle";
import XLabel from "@/Components/Label";
import XText from "@/Components/Text";
import XDivider from "@/Components/Divider";
import XButton from "@/Components/Button";
import XIconButton from "@/Components/IconButton";
import { MapIcon } from "@heroicons/vue/outline"
export default {
    name: 'ReservationActionCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XLabel,
        XText,
        XDivider,
        XButton,
        XIconButton,
        MapIcon,
    },
    methods: {
        cancelReservation() {
            alert("Hello world")
            return
        },
    },
    props: {
        reservation: {
            required: true,
            type: Object,
            validator: (reservation) => {
                return typeof reservation['id'] === 'number'
                    && typeof reservation['stand_name'] === 'string'
                    && typeof reservation['stand_location'] === 'string'
                    && typeof reservation['position_type'] === 'string';
            }
        }
    },
}
</script>

<style scoped>

</style>
