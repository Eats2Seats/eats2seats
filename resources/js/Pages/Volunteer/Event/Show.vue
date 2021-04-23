<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <x-card>
            <x-title>
                Event
            </x-title>
            <x-subtitle>
                View details about this upcoming event.
            </x-subtitle>
            <x-divider/>
            <x-label>
                Title
            </x-label>
            <x-text>
                {{ event.title }}
            </x-text>
            <x-divider/>
            <div class="flex flex-row items-center justify-between">
                <div>
                    <x-label>
                        Location
                    </x-label>
                    <x-text>
                        {{ venue.name }}
                    </x-text>
                </div>
                <div>
                    <a
                        :href="googleMapsLink"
                        target="_blank"
                    >
                        <x-icon-button>
                            <MapIcon class="h-6 w-6 text-gray-500"/>
                        </x-icon-button>
                    </a>
                </div>
            </div>
            <x-divider/>
            <x-label>
                Start
            </x-label>
            <x-text>
                {{ formatDate(event.start) }}
            </x-text>
            <x-divider/>
            <x-label>
                End
            </x-label>
            <x-text>
                {{ formatDate(event.end) }}
            </x-text>
        </x-card>
        <x-card>
            <x-title>
                Positions
            </x-title>
            <x-subtitle>
                View all staffing positions that are available to reserve.
            </x-subtitle>
            <x-divider/>
            <x-subtitle class="!font-bold">
                Position Options
            </x-subtitle>
            <x-divider/>
            <div>
                <x-label>
                    Affiliation
                </x-label>
                <select
                    name="affiliation"
                    id="affiliation-select"
                    class="w-full"
                    v-model="form.affiliation"
                >
                    <option :value="null">Independent</option>
                </select>
            </div>
            <div class="mt-3 md:mt-4">
                <x-label>
                    Position Type
                </x-label>
                <select
                    name="position_type"
                    id="position_type-select"
                    class="w-full"
                    v-model="form.position_type"
                >
                    <option :value="null">Any</option>
                    <option
                        v-for="position in positions.position_types"
                        :key="position"
                        :value="position"
                    >
                        {{ position }}
                    </option>
                </select>
            </div>
            <x-divider/>
            <x-subtitle class="!font-bold">
                Available Positions
            </x-subtitle>
            <div
                v-for="position in positions.list.data"
                :key="position.id"
            >
                <x-divider/>
                <inertia-link :href="formatReservationClaimUrl(position)" >
                    <div class="flex flex-row items-center justify-between">
                        <div>
                            <x-text>
                                {{ position.stand_name }}
                            </x-text>
                            <x-label>
                                {{ position.position_type }}, {{ position.remaining }} {{ position.remaining === 1 ? 'position' : 'positions' }} remaining
                            </x-label>
                        </div>
                        <div>
                            <chevron-right-icon class="h-5 w-5 text-gray-500"/>
                        </div>
                    </div>
                </inertia-link>
            </div>
            <x-divider/>
            <x-pagination :list="positions.list"/>
        </x-card>
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import XCard from "@/Components/Card";
import XTitle from "@/Components/Title";
import XSubtitle from "@/Components/Subtitle";
import XLabel from "@/Components/Label";
import XText from "@/Components/Text";
import XDivider from "@/Components/Divider";
import XButton from "@/Components/Button";
import XIconButton from "@/Components/IconButton";
import XPagination from "@/Components/Pagination";
import { MapIcon, ChevronRightIcon, SearchIcon } from "@heroicons/vue/outline";
import throttle from "lodash/throttle";
export default {
    name: 'Show',
    components: {
        VolunteerLayout,
        XCard,
        XTitle,
        XSubtitle,
        XLabel,
        XText,
        XDivider,
        XButton,
        XIconButton,
        XPagination,
        MapIcon,
        ChevronRightIcon,
        SearchIcon,
    },
    props: {
        event: Object,
        venue: Object,
        positions: Array,
        filters: Object,
    },
    data() {
        return {
            breadcrumbs: [
                { name: 'Events', url: '/volunteer/events' },
                { name: 'Event', url: window.location.pathname },
            ],
            form: {
                affiliation: this.filters.affiliation ? this.filters.affiliation : null,
                position_type: this.filters.position_type ? this.filters.position_type : null,
            }
        }
    },
    computed:{
        googleMapsLink () {
            return `https://www.google.com/maps/place/${this.venue.street}+${this.venue.city}+${this.venue.state}+${this.venue.zip}`.split(' ').join('+');
        },
    },
    methods: {
        formatDate (rawDate) {
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
        formatReservationClaimUrl (position) {
            return this.route('volunteer.reservations.claim', {
                event: position.event_id,
                stand: position.stand_id,
                positionType: position.position_type,
            });
        },
    },
    watch: {
        form: {
            handler: throttle(function () {
                this.$inertia.get(this.route('volunteer.events.show', {
                    id: this.event.id,
                    _query: Object.keys(this.form)
                        ? this.form
                        : { remember: 'forget' }
                }
                ), this.form, {
                    preserveState: true,
                    preserveScroll: true,
                });
            }, 150),
            deep: true,
        }
    }
}
</script>

<style scoped>

</style>
