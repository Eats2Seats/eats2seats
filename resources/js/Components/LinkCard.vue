<template>
    <inertia-link :href="href">
        <x-card>
            <!-- Wrap in link tag-->
            <div class="flex flex-col p-1">
                <div class="flex justify-between">
                    <!-- Make sure these colors aren't flipped backwards-->
                    <slot name="icon"/>
                    <div class="">
                        <arrow-up-icon class="w-5 h-5 text-gray-300 transform rotate-45"/>
                    </div>
                </div>
            </div>
            <x-title>
                <slot name="cardTitle"/>
            </x-title>
            <x-subtitle>
                <slot name="cardSubtitle"/>
            </x-subtitle>
        </x-card>
    </inertia-link>
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
import { ArrowUpIcon } from "@heroicons/vue/outline"

export default {
    name: 'LinkCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XLabel,
        XText,
        XDivider,
        XButton,
        XIconButton,
        ArrowUpIcon,
    },
    props: {},
    methods: {},
}
</script>

<style scoped>

</style>
