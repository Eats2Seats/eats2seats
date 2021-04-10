<template>
    <x-card>
        <x-title>
            Actions
        </x-title>
        <x-subtitle>
            Manage your reservation using the available actions. To modify a reservation please delete it and register again. 
        </x-subtitle>
        <x-divider/>
        <x-button>
            Cancel Reservation
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
