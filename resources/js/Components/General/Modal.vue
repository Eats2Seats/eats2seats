<template>
    <Dialog
        :open="isOpen"
        @close="setIsOpen"
        class="fixed inset-0 z-10 overflow-y-auto"
    >
        <div class="flex items-center justify-center min-h-screen">
            <DialogOverlay class="fixed inset-0 bg-black opacity-30" />

            <x-card class="z-50 max-w-md mx-auto shadow-xl space-y-6">
                <DialogTitle>
                    <x-title>
                        <slot name="title">Cancel your Reservation</slot>
                    </x-title>
                </DialogTitle>
                <DialogDescription>
                    <slot name="description"></slot>
                </DialogDescription>
                <div class="flex space-x-4">
                    <x-button
                        @click="setIsOpen(false)"
                        class="!bg-gray-500 !text-white !border-none hover:!bg-gray-600"
                    >
                        Cancel
                    </x-button>
                    <slot name="button"></slot>
                </div>
            </x-card>
        </div>
    </Dialog>
</template>

<script>
import {Dialog, DialogOverlay, DialogTitle, DialogDescription } from "@headlessui/vue";
import XCard from "@/Components/General/XCard";
import XTitle from "@/Components/General/XTitle";
import XDivider from "@/Components/General/XDivider";
import XSubtitle from "@/Components/General/XSubtitle";
import XText from "@/Components/General/XText";
import XButton from "@/Components/General/XButton";
import XIconButton from "@/Components/General/XIconButton";
import {XIcon} from "@heroicons/vue/solid";

export default {
    components: {
        XIconButton,
        XButton,
        XText,
        XSubtitle,
        XDivider,
        XTitle,
        XCard,
        Dialog,
        DialogOverlay,
        DialogTitle,
        DialogDescription,
        XIcon
    },
    data () {
        return {
            isOpen: false,
        }
    },
    methods: {
        setIsOpen(value) {
            this.isOpen = value;
        },
    },
};
</script>


<style scoped>

</style>
