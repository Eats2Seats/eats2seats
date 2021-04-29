<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <venue-matrix :venues="venues"/>
    </admin-layout>
</template>

<script>
import {ref} from "vue";
import AdminLayout from "@/Layouts/AdminLayout";
import VenueMatrix from "@/Components/Pages/Admin/Venue/Index/VenueMatrix";

export default {
    name: 'Index',
    components: {
        VenueMatrix,
        AdminLayout,
    },
    props: {
        venues: {
            type: Object,
            required: true,
        },
    },
    setup (props, context) {
        const breadcrumbs = ref([
            { name: 'Venues', url: window.location.pathname },
        ]);

        return {
            breadcrumbs,
        }
    }
}
</script>

<style scoped>

</style>
