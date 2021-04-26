<template>
    <x-card>
        <!-- User profile picture-->
        <div class="flex flex-wrap justify-center">
            <img class="inline object-cover w-16 h-16 mr-2 rounded-full"
                :src="getProfilePicture()" alt= "profile picture"/>
        </div>

        <x-subtitle class="flex justify-center">
            Welcome back
        </x-subtitle>
        <!-- Username-->
        <x-title class="flex justify-center">
            {{ $props.user.name }}
        </x-title>
        <!-- Manage account button -->
        <!-- TODO: Adjust colors as needed-->
        <button class="w-full py-3 text-center text-gray-600 border border-gray-600 rounded hover:bg-gray-600 hover:text-white">
            Manage Account
        </button>
        <x-divider />
        <x-text>
            <slot name="hoursWorked" />
        </x-text>
        <x-divider />
        <x-text>
            <slot name="earnings" />
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
export default {
    name: 'UserCard',
    components: {
        XCard,
        XTitle,
        XSubtitle,
        XLabel,
        XText,
        XDivider,
        XButton,
        XIconButton,
    },
    methods: {
        getProfilePicture() {
            return this.user.profile_photo_url
        },
    },
    props: {
        user: {
            required: true,
            type: Object,
        }
    },
}
</script>

<style scoped>

</style>
