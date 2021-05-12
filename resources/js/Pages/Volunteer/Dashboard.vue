<template>
    <volunteer-layout :breadcrumbs="breadcrumbs">
        <div class="mt-8 grid grid-cols-1 grid-flow-row gap-8">
            <div class="p-8 bg-white shadow-md">
                <p class="font-sans font-normal text-xl text-gray-700">
                    Welcome Back
                </p>
                <p class="font-sans font-bold text-2xl text-gray-700">
                    {{ user.first_name }} {{ user.last_name }}
                </p>
                <hr class="my-6"/>
                <div v-if="reservation">
                    <p class="font-sans font-normal text-base text-gray-700">
                        Just as a reminder, your next event is:
                    </p>
                    <ol class="mt-4 ml-4 space-y-4 list-disc list-outside font-sans font-normal text-base text-gray-700">
                        <li><span class="font-bold">{{ reservation.event.title }}</span></li>
                        <li>at <span class="font-bold">{{ reservation.event.venue.name }}</span></li>
                        <li>on <span class="font-bold">{{ reservation.start_date }}</span></li>
                        <li>from <span class="font-bold">{{ reservation.start_time }}</span> to <span class="font-bold">{{ reservation.end_time }}</span></li>
                    </ol>
                    <p class="mt-6 font-sans font-normal text-base text-gray-700">
                        <inertia-link
                            class="text-indigo-600 underline hover:text-indigo-700"
                            :href="route('volunteer.reservations.show', {id: reservation.id})"
                        >
                            View all of the details
                        </inertia-link>
                    </p>
                </div>
                <div v-else>
                    <p class="font-sans font-normal text-base text-gray-700">
                        You haven't signed up for an event yet! Fortunately, reserving a position at an event is easy:
                    </p>
                    <ol class="mt-4 ml-4 space-y-4 list-decimal list-outside font-sans font-normal text-base text-gray-700">
                        <li>Choose an event near you that works with your schedule.</li>
                        <li>Choose an available positions at a stand you'd like to staff.</li>
                        <li>Confirm your reservation.</li>
                    </ol>
                    <p class="mt-6 font-sans font-normal text-base text-gray-700">
                        <inertia-link
                            class="text-indigo-600 underline hover:text-indigo-700"
                            :href="route('volunteer.events.index')"
                        >
                            View all upcoming events
                        </inertia-link>
                    </p>
                </div>
            </div>
            <div class="p-8 bg-white shadow-md">
                <h3 class="font-sans font-bold text-xl text-gray-700">
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
        </div>
<!--        <div class="mt-12 w-full h-full grid grid-cols-2 grid-rows-2 gap-12">-->
<!--            <div class="p-8 bg-white shadow-md">-->
<!--                <h3 class="font-sans font-bold text-2xl text-gray-700">-->
<!--                    What is Eats2Seats?-->
<!--                </h3>-->
<!--                <div class="mt-4 bg-gray-50 aspect-w-16 aspect-h-9 shadow-sm">-->
<!--                    <iframe-->
<!--                        src="https://www.youtube.com/embed/S3ih2cMmEoU"-->
<!--                        title="YouTube video player"-->
<!--                        frameborder="0"-->
<!--                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"-->
<!--                        allowfullscreen-->
<!--                    />-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="p-8 bg-white shadow-md flex flex-col items-center">-->
<!--                <x-subtitle class="mt-0">-->
<!--                    Welcome back-->
<!--                </x-subtitle>-->
<!--                <x-title>-->
<!--                    Deven Jahnke-->
<!--                </x-title>-->
<!--            </div>-->
<!--            <div class="p-8 bg-white shadow-md flex flex-col items-center">-->
<!--                <div class="flex flex-col">-->
<!--                    <x-subtitle class="mt-0">-->
<!--                        My Next Event-->
<!--                    </x-subtitle>-->
<!--                    <x-title>-->
<!--                        UNC vs Duke-->
<!--                    </x-title>-->
<!--                </div>-->
<!--                <div class="mt-8 grid grid-cols-2 gap-y-8 gap-x-12">-->
<!--                    <div class="">-->
<!--                        <x-label>-->
<!--                            Location-->
<!--                        </x-label>-->
<!--                        <x-text>-->
<!--                            Dean Smith Center-->
<!--                        </x-text>-->
<!--                    </div>-->
<!--                    <div class="">-->
<!--                        <x-label>-->
<!--                            Stand-->
<!--                        </x-label>-->
<!--                        <x-text>-->
<!--                            Carrie's Cotton Candy-->
<!--                        </x-text>-->
<!--                    </div>-->
<!--                    <div class="">-->
<!--                        <x-label>-->
<!--                            Start-->
<!--                        </x-label>-->
<!--                        <x-text>-->
<!--                            March 23rd @ 2:00 PM-->
<!--                        </x-text>-->
<!--                    </div>-->
<!--                    <div class="">-->
<!--                        <x-label>-->
<!--                            End-->
<!--                        </x-label>-->
<!--                        <x-text>-->
<!--                            March 23rd @ 7:30 PM-->
<!--                        </x-text>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
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
    props: {
        user: Object,
        reservation: Object,
    },
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
