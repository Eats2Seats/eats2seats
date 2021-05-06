<template>
    <div class="flex flex-col">
        <label
            :for="field"
            class="font-sans font-normal text-base text-gray-500"
        >
            <slot></slot>
            <span v-if="required" class="text-red-600">*</span>
        </label>
        <input
            v-model="value"
            :type="type"
            :id="field"
            :name="field"
            class="mt-1"
            :autocomplete="autocomplete"
            :placeholder="placeholder"
            @input="clearError"
        />
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
    name: 'FormInput',
    components: {},
    props: {
        field: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        required: {
            type: Boolean,
            required: false,
        },
        placeholder: {
            type: String,
            required: true,
        },
        autocomplete: {
            type: String,
            required: false,
        }
    },
    setup(props, context) {
        // Inject form object
        const form = inject('form');

        const value = computed({
            get: () => form[props.field],
            set: val => form[props.field] = val,
        });

        const error = computed({
            get: () => form.errors[props.field],
            set: val => form.errors[props.field] = val,
        });

        const clearError = () => error.value = null;

        return {
            value,
            error,
            clearError
        };
    },
}
</script>

<style scoped>

</style>
