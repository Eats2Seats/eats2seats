<template>
    <div class="container mx-auto h-screen flex flex-col justify-center items-center">
        <div class="sm:w-[640px] flex flex-col">
            <div class="w-full flex flex-col bg-white rounded p-8 shadow-lg">
                <h1 class="font-sans font-bold text-2xl text-gray-700">
                    Request Password Reset Link
                </h1>
                <hr class="my-4"/>
                <p class="font-sans font-normal text-base text-gray-700">
                    Forgot your password? No problem. Just let us know your email address and we'll email you a password reset link that will allow you to choose a new one.
                </p>
                <p
                    v-if="emailSent"
                    class="mt-4 font-sans font-normal text-base text-green-600"
                >
                    A new password reset email has been sent!
                </p>
                <form
                    @submit.prevent="submit"
                    class="mt-4 space-y-4"
                >
                    <form-input
                        field="email"
                        type="email"
                        placeholder="john@doe.com"
                        autocomplete="email"
                        required
                    >
                        Email
                    </form-input>
                    <div class="!mt-8 flex flex-row justify-between items-end">
                        <button
                            type="submit"
                            class="py-3 px-6 text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow-sm disabled:bg-gray-500 disabled:cursor-wait"
                            :disabled="form.processing"
                        >
                            Email Password Reset Link
                        </button>
                        <inertia-link
                            :href="route('login')"
                            class="text-right font-sans font-normal text-base text-indigo-600 underline hover:text-indigo-700"
                        >
                            Login instead
                        </inertia-link>
                    </div>
                </form>

            </div>
        </div>
        <h1 class="absolute bottom-0 mb-12 font-sans font-bold text-gray-300 text-3xl">
            Eats2Seats
        </h1>
    </div>
</template>

<script>
    import FormInput from "@/Components/Form/FormInput";
    import {inject, provide, ref} from "vue";
    import {useForm} from "@inertiajs/inertia-vue3";

    export default {
        name: 'ForgotPassword',
        components: {FormInput},
        props: {},
        setup(props, context) {
            // Inject Ziggy route helper
            const route = inject('route');

            // Define reactive Inertia form object
            const form = useForm({
                email: null,
            });

            // Define reactive variable to track if email was sent
            const emailSent = ref(false);

            // Define function to submit form
            const submit = () => {
                form.post(route('password.email'), {
                    onSuccess: () => {
                        form.errors = null;
                        emailSent.value = true;
                    }
                });
            };

            // Provide form object to children components
            provide('form', form);

            return {
                route,
                emailSent,
                form,
                submit,
            }
        }
    }
</script>
