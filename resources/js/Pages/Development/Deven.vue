<template>
    <dev-layout class="p-4">
        <div class="min-w-full flex flex-col space-y-9">
            <navigation-action-card
                href="#"
                iconTextColor="text-lime-600"
                iconBackgroundColor="bg-lime-200"
            >
                <template v-slot:icon-path>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                    />
                </template>
                <template v-slot:title>
                    Upcoming Events
                </template>
                <template v-slot:desc>
                    Register for one or more upcoming events of your choice.
                </template>
            </navigation-action-card>
            <navigation-action-card
                href="#"
                iconTextColor="text-amber-600"
                iconBackgroundColor="bg-amber-200"
            >
                <template v-slot:icon-path>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </template>
                <template v-slot:title>
                    My Organizations
                </template>
                <template v-slot:desc>
                    Volunteer on behalf of organizations you belong to.
                </template>
            </navigation-action-card>
            <navigation-action-card
                href="#"
                iconTextColor="text-cyan-600"
                iconBackgroundColor="bg-cyan-200"
            >
                <template v-slot:icon-path>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    />
                </template>
                <template v-slot:title>
                    Training Resources
                </template>
                <template v-slot:desc>
                    Review useful training materials to help prepare for your events.
                </template>
            </navigation-action-card>
            <navigation-action-card
                href="#"
                iconTextColor="text-fuchsia-600"
                iconBackgroundColor="bg-fuchsia-200"
            >
                <template v-slot:icon-path>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"
                    />
                </template>
                <template v-slot:title>
                    My Events
                </template>
                <template v-slot:desc>
                    View the events you’ve registered for and have attended in the past.
                </template>
            </navigation-action-card>
            <card>
                <template #header>
                    <h3 class="">
                        Header
                    </h3>
                </template>
                <template #body>
                    <h3 class="">
                        Body
                    </h3>
                </template>
                <template #footer>
                    <h3 class="">
                        Footer
                    </h3>
                </template>
            </card>
            <card>
                <template #header>
                    <h3 class="">
                        Header
                    </h3>
                </template>
                <template #body>
                    <h3 class="">
                        Body
                    </h3>
                </template>
            </card>
            <card>
                <template #body>
                    <h3 class="">
                        Body
                    </h3>
                </template>
            </card>
        </div>
    </dev-layout>
</template>

<script>
import DevLayout from "@/Layouts/DevLayout";
import NavigationActionCard from "@/Components/NavigationActionCard";
import Card from "@/Components/Card";
export default {
    components: {
        DevLayout,
        NavigationActionCard,
        Card,
    },
    props: {},
    data () {
        return {

        }
    },
}
</script>
