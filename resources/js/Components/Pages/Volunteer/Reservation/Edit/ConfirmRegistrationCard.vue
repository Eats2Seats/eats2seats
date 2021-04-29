<template>
    <x-card>
        <x-title>
            Confirm Reservation
        </x-title>
        <x-subtitle>
            Review the reservation details for this event before committing to attend.
        </x-subtitle>
        <x-divider/>
        <x-subtitle class="!font-bold !mt-0">
            Event
        </x-subtitle>
        <table class="table-fixed w-full mt-4">
            <tbody>
                <tr>
                    <td class="w-20 pb-2">
                        <x-label class="!mb-0">Name</x-label>
                    </td>
                    <td class="max-w-full pb-2">
                        <x-text>{{ event.title }}</x-text>
                    </td>
                </tr>
                <tr>
                    <td class="py-2">
                        <x-label class="!mb-0">Start</x-label>
                    </td>
                    <td class="py-2">
                        <x-text>{{ formatDate(event.start) }}</x-text>
                    </td>
                </tr>
                <tr>
                    <td class="pt-2">
                        <x-label class="!mb-0">End</x-label>
                    </td>
                    <td class="pt-2">
                        <x-text>{{ formatDate(event.end) }}</x-text>
                    </td>
                </tr>
            </tbody>
        </table>
        <x-divider/>
        <x-subtitle class="!font-bold">
            Venue
        </x-subtitle>
        <table class="table-fixed w-full mt-4">
            <tbody>
            <tr>
                <td class="w-20 pb-2">
                    <x-label class="!mb-0">Name</x-label>
                </td>
                <td class="max-w-full pb-2">
                    <x-text>{{ venue.name }}</x-text>
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    <x-label class="!mb-0">Street</x-label>
                </td>
                <td class="py-2">
                    <x-text>{{ venue.street }}</x-text>
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    <x-label class="!mb-0">City</x-label>
                </td>
                <td class="py-2">
                    <x-text>{{ venue.city }}</x-text>
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    <x-label class="!mb-0">State</x-label>
                </td>
                <td class="py-2">
                    <x-text>{{ venue.state }}</x-text>
                </td>
            </tr>
            <tr>
                <td class="pt-2">
                    <x-label class="!mb-0">Zip</x-label>
                </td>
                <td class="pt-2">
                    <x-text>{{ venue.zip }}</x-text>
                </td>
            </tr>
            </tbody>
        </table>
        <x-divider/>
        <x-subtitle class="!font-bold">
            Position
        </x-subtitle>
        <table class="table-fixed w-full mt-4">
            <tbody>
            <tr>
                <td class="w-20 pb-2">
                    <x-label class="!mb-0">Stand</x-label>
                </td>
                <td class="max-w-full pb-2">
                    <x-text>{{ reservation.stand_name }}</x-text>
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    <x-label class="!mb-0">Type</x-label>
                </td>
                <td class="py-2">
                    <x-text>{{ reservation.position_type }}</x-text>
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    <x-label class="!mb-0">Location</x-label>
                </td>
                <td class="py-2">
                    <x-text>{{ reservation.stand_location }}</x-text>
                </td>
            </tr>
            <tr>
                <td class="w-16 pt-2">
                    <x-label class="!mb-0">Affiliation</x-label>
                </td>
                <td class="max-w-full pt-2">
                    <x-text>Independent</x-text>
                </td>
            </tr>
            </tbody>
        </table>
        <x-divider/>
        <x-button v-on:click="claimReservation">
            Claim the Reservation
        </x-button>
    </x-card>
</template>

<script>
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XSubtitle from "@/Components/General/XSubtitle";
import XDivider from "@/Components/General/XDivider";
import XLabel from "@/Components/General/XLabel";
import XText from "@/Components/General/XText";
import XButton from "@/Components/General/XButton";
export default {
    name: 'ConfirmRegistrationCard',
    components: {
        XText,
        XLabel,
        XDivider,
        XSubtitle,
        XTitle,
        XCard,
        XButton
    },
    props: {
        event: {
            type: Object,
            required: true,
        },
        venue: {
            type: Object,
            required: true,
        },
        reservation: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {};
    },
    methods: {
        formatDate(rawDate) {
            let dateObj = new Date(rawDate);
            let dateStr = dateObj.toLocaleDateString('en-US', {
                day: 'numeric',
                weekday: 'short',
                month: 'long',
                ...(new Date().getFullYear() !== dateObj.getFullYear() && { year: 'numeric'}),
            });
            let timeStr = dateObj.toLocaleTimeString('en-US', {
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
            });
            return `${dateStr} @ ${timeStr}`;
        },
        claimReservation () {
            this.$inertia.put(this.route('volunteer.reservations.update', { id: this.reservation.id }));
        }
    }
}
</script>

<style scoped>

</style>
