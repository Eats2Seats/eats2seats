<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <div class="mt-12 w-full h-full grid grid-cols-2 grid-rows-2 gap-12">
            <div class="p-8 bg-white shadow-md">
                <h3 class="font-sans font-bold text-2xl text-gray-700">
                    What is Eats2Seats?
                </h3>
                <div class="mt-4 bg-gray-50 aspect-w-16 aspect-h-9 shadow-sm">
                    <iframe
                        src="https://www.youtube.com/embed/S3ih2cMmEoU"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    />
                </div>
            </div>
            <div class="p-8 bg-white shadow-md flex flex-col items-center">
                <x-subtitle class="mt-0">
                    Welcome back
                </x-subtitle>
                <x-title>
                    Deven Jahnke
                </x-title>
            </div>
            <div class="p-8 bg-white shadow-md flex flex-col items-center">
                <div class="flex flex-col">
                    <x-subtitle class="mt-0">
                        My Next Event
                    </x-subtitle>
                    <x-title>
                        UNC vs Duke
                    </x-title>
                </div>
                <div class="mt-8 grid grid-cols-2 gap-y-8 gap-x-12">
                    <div class="">
                        <x-label>
                            Location
                        </x-label>
                        <x-text>
                            Dean Smith Center
                        </x-text>
                    </div>
                    <div class="">
                        <x-label>
                            Stand
                        </x-label>
                        <x-text>
                            Carrie's Cotton Candy
                        </x-text>
                    </div>
                    <div class="">
                        <x-label>
                            Start
                        </x-label>
                        <x-text>
                            March 23rd @ 2:00 PM
                        </x-text>
                    </div>
                    <div class="">
                        <x-label>
                            End
                        </x-label>
                        <x-text>
                            March 23rd @ 7:30 PM
                        </x-text>
                    </div>
                </div>
            </div>
        </div>
    </volunteer-layout>
</template>

<script>
import VolunteerLayout from "@/Layouts/VolunteerLayout";
import {ref} from "vue";
import XCard from "@/Components/General/XCard";
import XSubtitle from "@/Components/General/XSubtitle";
import XTitle from "@/Components/General/XTitle";
import XLabel from "@/Components/General/XLabel";
import XText from "@/Components/General/XText";
export default {
    name: 'Dashboard',
    components: {XText, XLabel, XTitle, XSubtitle, XCard, VolunteerLayout},
    props: {},
    setup(props, context) {
        const breadcrumbs = ref([
            { name: 'Dashboard', url: window.location.href }
        ]);

        return {
            breadcrumbs,
        };
    },
}
</script>

<style scoped>

</style>
