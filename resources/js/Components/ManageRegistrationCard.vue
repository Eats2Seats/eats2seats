<template>
    <card>
        <template #header>
            <p class="font-serif text-lg font-bold text-gray-700">
                Registration Options
            </p>
        </template>

        <template #body>
            <div class="grid grid-cols-1 divide-y divide-gray-300">
                <!-- Affiliation Feild-->
                <div class="p-4">
                    <p class="font-serif text-sm text-gray-500 font-regular">Affiliation</p>

                    <div class="col-span-6 sm:col-span-3">
                        <select id="affiliation" name="affiliation" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option>Red Cross</option>
                            <option>Interfaith Councel</option>
                            <option>Carolina for the Kids</option>
                            <option>Perl Hacks</option>
                        </select>
                    </div>
                </div>
                <!-- Position Type Feild-->
                <div class="p-4">
                    <p class="font-serif text-sm text-gray-500 font-regular">Position Type</p>
                    
                    <div class="col-span-6 pb-2 sm:col-span-3">
                        <select id="position-type" name="position-type" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option>Food Sales</option>
                            <option>Alcohol Sales</option>
                        </select>
                    </div>
                </div>
                <!-- Avaliable Positions Feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">Avaliable Positions</p>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="#" method="POST">
                                <div class="overflow-hidden shadow sm:rounded-md">
                                <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                                    
                                    <fieldset>
                                    <div>
                                        <legend class="text-base font-medium text-gray-900">Push Notifications</legend>
                                        <p class="text-sm text-gray-500">These are delivered via SMS to your mobile phone.</p>
                                    </div>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-center">
                                        <input id="push_everything" name="push_notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <label for="push_everything" class="block ml-3 text-sm font-medium text-gray-700">
                                            Everything
                                        </label>
                                        </div>
                                        <div class="flex items-center">
                                        <input id="push_email" name="push_notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <label for="push_email" class="block ml-3 text-sm font-medium text-gray-700">
                                            Same as email
                                        </label>
                                        </div>
                                        <div class="flex items-center">
                                        <input id="push_nothing" name="push_notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <label for="push_nothing" class="block ml-3 text-sm font-medium text-gray-700">
                                            No push notifications
                                        </label>
                                        </div>
                                    </div>
                                    </fieldset>
                                </div>
                                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                    </button>
                                </div>
                                </div>
                            </form>
                            </div>
                    <!-- Bottom-->
                </div>
                <!-- Liability Waiver Feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">Liability Waiver</p>

                </div>
                <!-- W-9 Form Feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">W-9 Form</p>

                </div>
            </div>
        </template>

        <template #footer>
            <button type="button">Register For Event</button>
        </template>
    </card>
</template>

<script>
import Card from "@/Components/Card"
export default {
    name: "ManageRegistrationCard",
    components: {
        Card,
    },
}
</script>

<style scoped>

</style>
