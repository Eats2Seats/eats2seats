<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <stand-matrix :stands="stands"/>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout";
import StandMatrix from "@/Components/Pages/Admin/Stand/StandMatrix";
import {ref} from "vue";
export default {
    name: 'Index',
    components: {
        StandMatrix,
        AdminLayout
    },
    props: {
        stands: {
            type: Object,
            required: true,
        },
    },
    setup (props, context) {
        // Define page breadcrumbs
        const breadcrumbs = ref([
            { name: 'Stands', url: window.location.pathname },
        ]);

        return {
            breadcrumbs,
        }
    }
}
</script>

<style scoped>

</style>
