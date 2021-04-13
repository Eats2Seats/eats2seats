<template>
    <x-card>
        <x-title>
            Affiliation
        </x-title>
        <x-subtitle>
            View details about the organization you've opted to donate your earnings to.
        </x-subtitle>
        <x-divider/>
        <x-label>
            Organization
        </x-label>
        <!-- American Red Cross-->
        <x-text>
            <slot name="organization"></slot>
        </x-text>
        <x-divider/>
        <x-label>
            Manager
        </x-label>
        <!-- Jane Doe-->
        <x-text>
            <slot name="manager"></slot>
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
