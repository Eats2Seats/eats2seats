<template>
    <card>
        <template #header>
            <div class="flex flex-col">
                <p class="font-serif font-bold text-gray-700 text-lg">
                    <p> Volunteer Information </p>
                </p>
            </div>
        </template>
        <template #body>
            <div class="flex-col divide-y divide-gray-300 space-y-4">
                <div class="flex flex-col px-6">
                    <p
                        class="font-serif font-regular text-gray-500 text-sm"
                    >
                        <p> Organization </p>
                    </p>
                    <p
                        class="mt-2 font-serif font-regular text-gray-700 text-base"
                    >
                        <slot name="org">
                            {{ organization }}
                        </slot>
                    </p>
                </div>
                <div class="flex flex-col px-6">
                    <p
                        class="mt-4 font-serif font-regular text-gray-500 text-sm"
                    >
                        <p> Manager </p>
                    </p>
                    <p
                        class="mt-2 font-serif font-regular text-gray-700 text-base"
                    >
                        <slot name="manager">
                            {{ manager }}
                        </slot>
                    </p>
                </div>
            </div>
        </template>
    </card>
</template>

<script>
import Card from "@/Components/Card";
export default {
    name: "VolunteerInformationCard",
    components: {
        Card,
    },
    data() {
        return {
            organization: "American Red Cross",
            manager: "John Doe",
        };
    },
};
</script>
