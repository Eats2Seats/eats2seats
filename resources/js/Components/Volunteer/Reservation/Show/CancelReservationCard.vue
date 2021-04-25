<template>
    <x-card>
        <x-title>
            Cancel
        </x-title>
        <x-subtitle>
            Cancel your reservation if you no longer wish to attend the event.
        </x-subtitle>
        <x-divider/>
        <x-button
            class="text-red-600 border-red-600 hover:bg-red-600"
            v-on:click="cancelReservation"
        >
            Cancel Your Reservation
        </x-button>
        <!--TODO Add cancellation confirmation-->
    </x-card>
</template>

<script>
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XSubtitle from "@/Components/General/XSubtitle";
import XDivider from "@/Components/General/XDivider";
import XButton from "@/Components/General/XButton";

export default {
    name: 'CancelReservationCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XDivider,
        XButton,
    },
    props: {
        reservation: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {};
    },
    methods: {
        cancelReservation () {
            this.$inertia.delete(this.route('volunteer.reservations.delete', {
                id: this.reservation.id
            }));
        }
    }
}
</script>

<style scoped>

</style>
