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
        <x-text>
            {{ reservation.stand_name }}
        </x-text>
        <x-divider/>
        <div class="flex flex-row items-center justify-between">
            <div>
                <x-label>
                    Location
                </x-label>
                <x-text>
                    {{ reservation.stand_location }}
                </x-text>
            </div>
            <div>
                <a
                    href="#"
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
            Position
        </x-label>
        <x-text>
            {{ reservation.position_type }}
        </x-text>
    </x-card>
</template>

<script>
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XSubtitle from "@/Components/General/XSubtitle";
import XText from "@/Components/General/XText";
import XLabel from "@/Components/General/XLabel";
import XDivider from "@/Components/General/XDivider";
import XIconButton from "@/Components/General/XIconButton";
import {MapIcon} from "@heroicons/vue/outline";

export default {
    name: 'StandDetailsCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XText,
        XLabel,
        XDivider,
        XIconButton,
        MapIcon,
    },
    props: {
        reservation: {
            type: Object,
            required: true,
        }
    },
}
</script>

<style scoped>

</style>
