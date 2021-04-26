<template>
    <volunteer-layout :breadcrumbs="breadcrumbs"> 
        <user-card :user="user">
            <template #hoursWorked>
                17 hours worked
            </template>
            <template #earnings>
                $420.69 earned
            </template>
        </user-card>
        <next-reservation :next="next" />
        <!-- A lot of this file could be split out into a single component file applied several times
        Feels easier to just do it this way for now-->

        <!-- UserCard
            NextReservationCard
            Reservations Link Card
            Events Card
            My Organizations Card
            Training Resources Card-->

        <!-- Reservations Link Card-->
        <link-card href="/volunteer/reservations">
            <template #icon>
                <div class="p-3 rounded shadow bg-fuchsia-200">
                    <ticket-icon class="w-5 h-5 text-fuchsia-600" />
                </div>
            </template>
            <template #cardTitle>
                Reservations
            </template>
            <template #cardSubtitle>
                View the events you have registered for and attended in the past.
            </template>
        </link-card>

        <!-- Events Link Card-->
        <link-card href="volunteer/events">
            <template #icon>
                <div class="p-3 rounded shadow bg-lime-200">
                    <clipboard-list-icon class="w-5 h-5 text-lime-600" />
                </div>
            </template>
            <template #cardTitle>
                Events
            </template>
            <template #cardSubtitle>
                Register for one or more upcoming events of your choice.
            </template>
        </link-card>
        
        <!-- My Organizations Link Card-->
        <link-card href="#">
            <template #icon>
                <div class="p-3 rounded shadow bg-amber-200">
                    <user-group-icon class="w-5 h-5 text-amber-600" />
                </div>
            </template>
            <template #cardTitle>
                My Organizations
            </template>
            <template #cardSubtitle>
                Volunteer on behalf of organizations you belong to.
            </template>
        </link-card>
        
        <!-- Training Resources Link Card-->
        <link-card v-on:click="test" href="">
            <template #icon>
                <div class="p-3 rounded shadow bg-cyan-200">
                    <book-open-icon class="w-5 h-5 text-cyan-600" />
                </div>
            </template>
            <template #cardTitle>
                Training Resources
            </template>
            <template #cardSubtitle>
                Review useful training materials to help prepare for your events.
            </template>
        </link-card>
    </volunteer-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import { TicketIcon, ArrowUpIcon, ClipboardListIcon, UserGroupIcon, BookOpenIcon } from "@heroicons/vue/outline"
    import XCard from "@/Components/Card"
    import XTitle from "@/Components/Title"
    import UserCard from "@/Components/UserCard"
    import VolunteerLayout from "@/Layouts/VolunteerLayout"
    import NextReservation from "@/Components/NextReservationCard"
    import LinkCard from "@/Components/LinkCard"


    export default {
        components: {
            AppLayout,
            Welcome,
            TicketIcon,
            ArrowUpIcon,
            ClipboardListIcon,
            XCard,
            XTitle,
            UserCard,
            VolunteerLayout,
            NextReservation,
            LinkCard,
            UserGroupIcon,
            BookOpenIcon,
        },
        props: {
            next: {
                required: true,
                type: Object,
            },
            user: {
                required: true,
                type: Object,
            },
        },
        methods: {},
        data() {
            return {
                breadcrumbs: [
                    { name: 'Dashboard', url: window.location.pathname}
                ]
            }
        },
    }
</script>
