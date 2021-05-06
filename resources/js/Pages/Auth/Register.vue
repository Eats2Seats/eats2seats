<template>
    <div class="container mx-auto h-screen flex flex-col justify-center items-center">
        <div class="sm:w-[640px] flex flex-col">
            <div class="w-full flex flex-col bg-white rounded p-8 shadow-lg">
                <h1 class="font-sans font-bold text-2xl text-gray-700">
                    Create an Account
                </h1>
                <hr class="my-4"/>
                <form
                    @submit.prevent="submit"
                    class="space-y-4"
                >
                    <form-input
                        field="first_name"
                        type="text"
                        placeholder="John"
                        autocomplete="given-name"
                        required
                    >
                        First Name
                    </form-input>
                    <form-input
                        field="last_name"
                        type="text"
                        placeholder="Doe"
                        autocomplete="family-name"
                        required
                    >
                        Last Name
                    </form-input>
                    <form-input
                        field="email"
                        type="email"
                        placeholder="john@doe.com"
                        autocomplete="email"
                        required
                    >
                        Email
                    </form-input>
                    <form-input
                        field="password"
                        type="password"
                        placeholder="password123"
                        autocomplete="new-password"
                        required
                    >
                        Password
                    </form-input>
                    <form-input
                        field="password_confirmation"
                        type="password"
                        placeholder="password123"
                        autocomplete="new-password"
                        required
                    >
                        Confirm Password
                    </form-input>
                    <button
                        type="submit"
                        class="!mt-8 w-full py-3 px-6 text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow-sm disabled:bg-gray-500 disabled:cursor-wait"
                        :disabled="form.processing"
                    >
                        Create Account
                    </button>
                </form>
                <inertia-link
                    :href="route('login')"
                    class="mt-4 text-right font-sans font-normal text-base text-indigo-600 underline hover:text-indigo-700"
                >
                    Login instead
                </inertia-link>
            </div>
        </div>
        <h1 class="absolute bottom-0 mb-12 font-sans font-bold text-gray-300 text-3xl">
            Eats2Seats
        </h1>
    </div>
</template>

<script>
    import {useForm} from "@inertiajs/inertia-vue3";
    import {inject, provide} from "vue";
    import FormInput from "@/Components/Form/FormInput";

    export default {
        name: 'Register',
        components: {FormInput},
        props: {},
        setup(props, context) {
            // Inject Ziggy route helper
            const route = inject('route');

            // Define reactive Inertia form object
            const form = useForm({
                first_name: null,
                last_name: null,
                email: null,
                password: null,
                password_confirmation: null,
            });

            // Define function to submit form
            const submit = () => {
                form.post(route('register'), {
                    preserveScroll: true,
                    preserveState: true,
                });
            };

            provide('form', form);

            return {
                route,
                form,
                submit,
            }
        }
    }
</script>
