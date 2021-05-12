<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <reservation-matrix :reservations="reservations"/>
    </admin-layout>
</template>

<script>
import {ref} from "vue";
import AdminLayout from "@/Layouts/AdminLayout";
import ReservationMatrix from "@/Components/Pages/Admin/Reservation/ReservationMatrix";

export default {
    name: 'Index',
    components: {ReservationMatrix, AdminLayout},
    props: {
        reservations: Object,
    },
    setup(props, context) {
        // Define page breadcrumbs
        const breadcrumbs = ref([
            { name: 'Reservations', url: window.location.pathname },
        ]);

        return {
            breadcrumbs
        };
    },
}
</script>

<style scoped>

</style>
