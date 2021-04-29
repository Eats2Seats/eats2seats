<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <events-matrix :events="events"/>
    </admin-layout>
</template>

<script>
import {ref} from "vue";
import AdminLayout from "@/Layouts/AdminLayout";
import EventsMatrix from "@/Components/Pages/Admin/Event/Index/EventsMatrix";
export default {
    name: 'Index',
    components: {
        EventsMatrix,
        AdminLayout
    },
    props: {
        events: {
            type: Object,
            required: true,
        },
        events2: {
            type: Object,
            required: true,
        },
    },
    setup (props, context) {
        const breadcrumbs = ref([
            { name: 'Events', url: window.location.pathname },
        ]);

        return {
            breadcrumbs,
        }
    }
}
</script>

<style scoped>

</style>
