<template>
    <div class="container mx-auto h-screen flex flex-col justify-center items-center">
        <div class="sm:w-[640px] flex flex-col">
            <div class="w-full flex flex-col bg-white rounded p-8 shadow-lg">
                <h1 class="font-sans font-bold text-2xl text-gray-700">
                    Sign In
                </h1>
                <hr class="my-4"/>
                <form
                    @submit.prevent="submit"
                    class="space-y-4"
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
                    <form-input
                        field="password"
                        type="password"
                        placeholder="password123"
                        autocomplete="current-password"
                        required
                    >
                        Password
                    </form-input>
                    <div class="mt-4 flex flex-row justify-between items-center">
                        <label
                            for="remember"
                            class="flex flex-row items-center space-x-2"
                        >
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="rounded border border-gray-300 focus:ring-indigo-600 checked:bg-indigo-600 checked:text-indigo-600"
                                v-model="form.remember"
                                autocomplete="rem"
                            >
                            <span class="font-sans font-normal text-base text-gray-700">
                                Remember me
                            </span>
                        </label>
                        <inertia-link
                            :href="route('password.request')"
                            class="font-sans font-normal text-base text-indigo-600 underline hover:text-indigo-700"
                        >
                            Reset your password
                        </inertia-link>
                    </div>
                    <button
                        type="submit"
                        class="!mt-8 w-full py-3 px-6 text-white bg-indigo-600 hover:bg-indigo-700 rounded shadow-sm disabled:bg-gray-500 disabled:cursor-wait"
                        :disabled="form.processing"
                    >
                        Log In
                    </button>
                </form>
                <inertia-link
                    :href="route('register')"
                    class="mt-4 text-right font-sans font-normal text-base text-indigo-600 underline hover:text-indigo-700"
                >
                    Register instead
                </inertia-link>
            </div>
        </div>
        <h1 class="absolute bottom-0 mb-12 font-sans font-bold text-gray-300 text-3xl">
            Eats2Seats
        </h1>
    </div>
</template>

<script>
    import FormInput from "@/Components/Form/FormInput";
    import {inject, provide} from "vue";
    import {useForm} from "@inertiajs/inertia-vue3";

    export default {
        name: 'Login',
        components: {FormInput},
        props: {},
        setup(props, context) {
            // Inject Ziggy route helper
            const route = inject('route');

            // Define reactive Inertia form object
            const form = useForm({
                email: null,
                password: null,
                remember: false,
            });

            // Define function to submit form
            const submit = () => {
                form.transform(data => ({
                    ...data,
                    remember: form.remember ? 'on' : '',
                }))
                .post(route('login'), {
                    onFinish: () => form.reset('password'),
                });
            }

            // Provide form to children components
            provide('form', form);

            return {
                route,
                form,
                submit,
            }
        }
    }
</script>
