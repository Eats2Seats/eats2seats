<template>
    <x-card>
        <x-title>
            My Reservations
        </x-title>
        <x-subtitle>
            View all past, present, and future events that you've committed to attending.
        </x-subtitle>
        <div class="flex bg-white shadow">
            

            <input class="w-full p-2 rounded" type="text" placeholder="Search">
            <button class="p-2 pl-4 pr-4 text-white bg-indigo-600 rounded hover:bg-indigo-500">
                    <p class="text-xs font-semibold">Search</p>
            </button>
        </div>
        <x-divider/>
        <!-- Reservation Cards go here-->
        <slot name="reservationCards"></slot>
        <!-- Nav Bar-->
        <div class="flex justify-between">
            <div class="">
                <x-icon-button>
                    <ArrowLeftIcon class="w-6 h-6 text-grey-500"/>
                </x-icon-button>
            </div>
            <div class="">
                <!-- Enter pageination info here-->
                <slot name="pagination"></slot>
            </div>
            <div class="">
                <x-icon-button>
                    <ArrowRightIcon class="w-6 h-6 text-grey-500"/>
                </x-icon-button>
            </div>
        </div>
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
import { ArrowLeftIcon } from "@heroicons/vue/outline"
import { ArrowRightIcon } from "@heroicons/vue/outline"
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
        ArrowLeftIcon,
        ArrowRightIcon
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
