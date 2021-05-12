<template>
    <div class="flex flex-col">
        <label
            :for="field"
            class="font-sans font-normal text-base text-gray-500"
        >
            <slot></slot>
            <span v-if="required" class="text-red-600">*</span>
        </label>
        <select
            v-model="value"
            :id="field"
            :name="field"
            class="mt-1"
            @input="clearError"
        >
            <option :value="null">Choose One</option>
            <option
                v-for="(option, id) in options"
                :key="option"
                :value="id"
            >
                {{ option }}
            </option>
        </select>
        <p
            v-if="error"
            class="mt-1 font-sans font-normal text-sm text-red-600"
        >
            {{ error }}
        </p>
    </div>
</template>

<script>
import {computed, inject} from "vue";

export default {
    name: 'FormSelect',
    components: {},
    props: {
        field: {
            type: String,
            required: true,
        },
        required: {
            type: Boolean,
            required: false,
        },
    },
    setup(props, context) {
        // Inject form object
        const form = inject('form');
        const formOptions = inject('form-options');

        const value = computed({
            get: () => form[props.field],
            set: val => form[props.field] = val,
        });

        const options = computed(() => formOptions[props.field]);

        const error = computed({
            get: () => form.errors[props.field],
            set: val => form.errors[props.field] = val,
        });

        const clearError = () => error.value = null;

        return {
            value,
            options,
            error,
            clearError
        };
    },
}
</script>

<style scoped>

</style>
