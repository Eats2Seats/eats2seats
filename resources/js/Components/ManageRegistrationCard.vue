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
                                        <div class="space-y-4">
                                            <div class="flex items-center">
                                                <input id="push_everything" name="push_notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                                <label for="push_everything" class="block ml-3 text-sm font-medium text-gray-700">
                                                    Bob's Burgers
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="push_email" name="push_notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                                <label for="push_email" class="block ml-3 text-sm font-medium text-gray-700">
                                                    Sal's Pizza
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="push_nothing" name="push_notifications" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                                <label for="push_nothing" class="block ml-3 text-sm font-medium text-gray-700">
                                                    Pantana Bob's (Alcohol)
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Liability Waiver Feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">Liability Waiver</p>
                    <div class="py-3">
                        <ul class="border border-gray-200 divide-y divide-gray-200 rounded-md">
                            <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                <div class="flex items-center flex-1 w-0">
                                    <!-- Heroicon name: solid/paper-clip -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="flex-1 w-0 ml-2 truncate">
                                        liability_waiver_stc.pdf
                                    </span>
                                </div>
                                <div class="flex-shrink-0 ml-4">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Download
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- W-9 Form Feild-->
                <div class="">
                    <p class="font-serif text-sm text-gray-500 font-regular">W-9 Form</p>
                    <div class="py-3">
                        <ul class="border border-gray-200 divide-y divide-gray-200 rounded-md">
                            <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                <div class="flex items-center flex-1 w-0">
                                    <!-- Heroicon name: solid/paper-clip -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="flex-1 w-0 ml-2 truncate">
                                        w9_form_stc.pdf
                                    </span>
                                </div>
                                <div class="flex-shrink-0 ml-4">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Download
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
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
