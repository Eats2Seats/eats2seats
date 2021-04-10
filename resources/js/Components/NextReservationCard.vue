<template>
    <x-card>
        <x-title>
            Next Reservation
        </x-title>
        <x-subtitle>
            View details for the next event you're scheduled to attend.
        </x-subtitle>

        <x-divider/>
        <x-label>
            Title
        </x-label>
        <!-- UNC Chapel Hill vs Duke-->
        <x-text>
            <slot name="title"></slot>
        </x-text>
        <x-divider/>
        <div class="flex items-center felx-row">
            <div class="flex flex-col flex-1">
                <x-lable>
                    Location
                </x-lable>
                <!-- Dean Smith Center-->
                <x-text>
                    <slot name="location"></slot>
                </x-text>
            </div>
            <div class ="ml-6">
                <x-icon-button>
                    <MapIcon class="w-6 h-6 text-grey-500" />
                </x-icon-button>
            </div>
        </div>
        <x-divider/>
        <x-label>
            Start
        </x-label>
        <!-- March 31st @ 5:00 PM-->
        <x-text>
            <slot name="start"></slot>
        </x-text>
        <x-divider/>
        <x-label>
            End
        </x-label>
        <!-- March 31st @8:00 PM-->
        <x-text>
            <slot name="end"></slot>
        </x-text>
        <x-divider/>
        <x-button>
            View More Details
        </x-button>
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
    props: {},
    data() {
        return {

        }
    },
}
</script>

<style scoped>

</style>
