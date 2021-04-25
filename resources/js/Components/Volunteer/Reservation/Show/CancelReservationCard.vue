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
            v-on:click="$refs.cancelReservationModal.setIsOpen(true)"
        >
            Cancel Your Reservation
        </x-button>
        <modal ref="cancelReservationModal">
            <template #title>
                Confirm Cancellation
            </template>
            <template #description>
                <x-text>
                    By cancelling your reservation, you acknowledge that you are forfeiting your position at this event.
                </x-text>
                <x-text class="mt-4">
                    If you cancel your reservation and later change your mind, we cannot guarantee position availability.
                </x-text>
            </template>
            <template #button>
                <x-button
                    class="!bg-red-500 !text-white !border-none hover:!bg-red-600"
                    @click="cancelReservation"
                >
                    Confirm
                </x-button>
            </template>
        </modal>
    </x-card>
</template>

<script>
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XSubtitle from "@/Components/General/XSubtitle";
import XDivider from "@/Components/General/XDivider";
import XButton from "@/Components/General/XButton";
import Modal from "@/Components/General/Modal";
import XText from "@/Components/General/XText";

export default {
    name: 'CancelReservationCard',
    components: {
        XText,
        XCard,
        XTitle,
        XSubtitle,
        XDivider,
        XButton,
        Modal,
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
