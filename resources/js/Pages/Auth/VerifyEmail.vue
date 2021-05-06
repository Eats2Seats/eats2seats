<template>
    <div class="container mx-auto h-screen flex flex-col justify-center items-center">
        <div class="sm:w-[640px] flex flex-col">
            <div class="w-full flex flex-col bg-white rounded p-8 shadow-lg">
                <h1 class="font-sans font-bold text-2xl text-gray-700">
                    Confirm Your Email
                </h1>
                <hr class="my-4"/>
                <p class="font-sans font-normal text-base text-gray-700">
                    Thanks for creating an account! Before you can continue, we just need you to verify your email address. We've gone ahead and sent an email to you, but you're welcome to request another using the button below.
                </p>
                <p
                    v-if="emailSent"
                    class="mt-4 font-sans font-normal text-base text-green-600"
                >
                    A new confirmation email has been sent!
                </p>
                <div class="flex flex-row justify-between items-end">
                    <form
                        @submit.prevent="submit"
                        class="space-y-4"
                    >
                        <button
                            type="submit"
                            class="!mt-8 py-3 px-6 text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow-sm disabled:bg-gray-500 disabled:cursor-wait"
                            :disabled="form.processing"
                        >
                            Resend Confirmation Email
                        </button>
                    </form>
                    <inertia-link
                        :href="route('logout')"
                        method="post"
                        class="mt-4 text-right font-sans font-normal text-base text-indigo-600 underline hover:text-indigo-700"
                    >
                        Logout instead
                    </inertia-link>
                </div>
            </div>
        </div>
        <h1 class="absolute bottom-0 mb-12 font-sans font-bold text-gray-300 text-3xl">
            Eats2Seats
        </h1>
    </div>
</template>

<script>
import {computed, inject, ref} from "vue";
    import {useForm} from "@inertiajs/inertia-vue3";

    export default {
        name: 'VerifyEmail',
        components: {},
        props: {},
        setup(props, context) {
            // Inject Ziggy route helper
            const route = inject('route');

            // Define reactive Inertia form object
            const form = useForm({});

            // Define reactive variable to determine if email sent
            const emailSent = ref(false)

            // Define method to submit form
            const submit = () => {
                form.post(route('verification.send'), {
                    onSuccess: () => {
                        emailSent.value = true;
                    }
                })
            };

            return {
                route,
                form,
                submit,
                emailSent,
            }
        }
    }
</script>
