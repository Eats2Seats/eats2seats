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
            <slot name="name"></slot>
        </x-text>
        <x-divider/>
        <div class="flex items-center felx-row">
            <div class="flex flex-col flex-1">
                <x-lable>
                    Location
                </x-lable>
                <!-- Concession Stand #2-->
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
            Position
        </x-label>
        <!-- Food Sales-->
        <x-text>
            <slot name="position"></slot>
        </x-text>
        <x-divider/>
        <x-label>
            Manager
        </x-label>
        <!-- Jim-->
        <x-text>
            <slot name="manager"></slot>
        </x-text>
        <x-divider/>
        <x-label>
            Attendance
        </x-label>
        <!-- TODO: Write conditional about if future or past event to add or remove attendance feild-->
        <!-- Present-->
        <x-text>
            <slot name="attendance"></slot>
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
    props: {},
    data() {
        return {

        }
    },
}
</script>

<style scoped>

</style>
