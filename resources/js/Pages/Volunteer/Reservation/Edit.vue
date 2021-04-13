<template>
    <x-card>
        <x-title>
            Reservation
        </x-title>
        <x-subtitle>
            View details about the reservation you're claiming.
        </x-subtitle>
        <x-divider/>
        <x-label>
            Affiliation
        </x-label>
        <x-text>
            Independent
        </x-text>
        <x-divider/>
        <x-label>
            Stand
        </x-label>
        <x-text>
            {{ $props.reservation.stand_name }}
        </x-text>
        <x-divider/>
        <x-label>
            Location
        </x-label>
        <x-text>
            {{ $props.reservation.stand_location }}
        </x-text>
        <x-divider/>
        <x-label>
            Position Type
        </x-label>
        <x-text>
            {{ $props.reservation.position_type }}
        </x-text>
    </x-card>
    <x-card class="mt-8">
        <x-title>
            Claim
        </x-title>
        <x-subtitle>
            By claiming this reservation you are committing to attending the event.
        </x-subtitle>
        <x-divider/>
        <x-label>
            Event
        </x-label>
        <x-text>
            {{ $props.event.title }}
        </x-text>
        <x-divider/>
        <x-label>
            Location
        </x-label>
        <x-text>
            {{ $props.venue.name }}
        </x-text>
        <x-divider/>
        <x-label>
            Start
        </x-label>
        <x-text>
            {{ $props.event.start }}
        </x-text>
        <x-divider/>
        <x-label>
            End
        </x-label>
        <x-text>
            {{ $props.event.end }}
        </x-text>
        <x-divider/>
        <x-button v-on:click="claim">
            Claim the Reservation
        </x-button>
    </x-card>
</template>

<script>
import XCard from '@/Components/Card';
import XTitle from '@/Components/Title';
import XSubtitle from '@/Components/Subtitle';
import XDivider from '@/Components/Divider';
import XLabel from '@/Components/Label';
import XText from '@/Components/Text';
import XButton from '@/Components/Button';
export default {
    name: 'Edit',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XDivider,
        XLabel,
        XText,
        XButton,
    },
    props: {
        user: {
            required: true,
            type: Object,
        },
        event: {
            required: true,
            type: Object,
            validator: (event) => {
                return typeof event['title'] === 'string'
                    && !isNaN(Date.parse(event['start']))
                    && !isNaN(Date.parse(event['end']));
            },
        },
        venue: {
            required: true,
            type: Object,
            validator: (venue) => {
                return typeof venue['name'] === 'string'
                    && typeof venue['street'] === 'string'
                    && typeof venue['city'] === 'string'
                    && typeof venue['state'] === 'string'
                    && typeof venue['zip'] === 'string';
            },
        },
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
    data() {
        return {
            form: this.$inertia.form({
                user_id: this.$props.user.id,
            }),
        }
    },
    methods: {
        claim() {
            this.form.put('/volunteer/reservations/' + this.reservation.id);
        }
    }
}
</script>

<style scoped>

</style>
