<template>
    <x-card>
        <x-title>
            Stand
        </x-title>
        <x-subtitle>
            View details about the concession stand you reserved a position at.
        </x-subtitle>

        <x-divider/>
        <x-label>
            Name
        </x-label>
        <!-- Carrie's Cotton Candy-->
        <x-text>
            {{ $props.reservation.stand_name }}
        </x-text>
        <x-divider/>
        <div class="flex items-center felx-row">
            <div class="flex flex-col flex-1">
                <x-lable>
                    Location
                </x-lable>
                <!-- Concession Stand #2-->
                <x-text>
                    {{ $props.reservation.stand_location }}
                </x-text>
            </div>
            <div class ="ml-6">
                <x-icon-button>
                    <MapIcon class="w-6 h-6 text-gray-500" />
                </x-icon-button>
            </div>
        </div>
        <x-divider/>
        <x-label>
            Position
        </x-label>
        <!-- Food Sales-->
        <x-text>
            {{ $props.reservation.position_type }}
        </x-text>
        <x-divider/>
        <x-label>
            Manager
        </x-label>
        <!-- Jim-->
        <x-text>
            Not Supported
        </x-text>
        <x-divider/>
        <x-label>
            Attendance
        </x-label>
        <!-- TODO: Write conditional about if future or past event to add or remove attendance feild-->
        <!-- Present-->
        <x-text>
            Not supported
        </x-text>
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
    name: 'NextEvent',
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
