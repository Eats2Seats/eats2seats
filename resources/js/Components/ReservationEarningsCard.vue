<template>
    <x-card>
        <x-title>
            Earnings
        </x-title>
        <x-subtitle>
            View details about your earnings from staffing the event. 
        </x-subtitle>
        <x-divider/>
        <x-label>
            Total
        </x-label>
        <x-text>
            <slot name="total"></slot>
        </x-text>
        <x-divider/>
        <div class="flex flex-row items-center">
            <div class="flex flex-col flex-1">
                <x-label>
                    Recepient
                </x-label>
                <x-text>
                    <slot name="recepient"></slot>
                </x-text>
            </div>
            <div class="ml-6">
                <x-icon-button>
                    <InformationCircleIcon class="w-6 h-6 text-grey-500"/>
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
import { InformationCircleIcon } from "@vue-hero-icons/outline"
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
        InformationCircleIcon,
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
