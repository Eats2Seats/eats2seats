<template>
    <card>
        <template #header>
            <p class="font-serif text-lg font-bold text-grey-700">
                Stand information
            </p>
        </template>
    
        <template #body>
            <div class="grid grid-cols-1 divide-y divide-grey-300">
                <!-- Name feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">Name</p>
                    <p class="mt-2 font-serif text-base text-gray-700 font-regular">
                        {{name}}
                    </p>
                </div>
                <!-- Location feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">Location</p>
                    <div class="flex justify-between">
                        <p class="mt-2 font-serif text-base text-gray-700 font-regular">
                            {{location}}
                        </p>
                        <div class="">
                            <svg
                                    class="w-6 h-6"
                                    :class="iconTextColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    stroke-width="2" 
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" 
                                    />

                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Position feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">Position</p>
                    <p class="mt-2 font-serif text-base text-gray-700 font-regular">
                        {{position}}
                    </p>
                </div>
            </div>
        </template>
    </card>
</template>




<script>
import Card from "@/Components/Card";
export default {
    name: "StandInformationCard",
    components: {
        Card,
    },
    data () {
        return {
            name: 'Joe\'s Hot Dogs',
            location: 'Stand 13',
            position: 'Alcohol Sales',
        }
    }
}
</script>

<style scoped>

</style>
