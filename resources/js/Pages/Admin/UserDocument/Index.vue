<template>
    <admin-layout :breadcrumbs="breadcrumbs">
        <user-documents-matrix :user_documents="user_documents"/>
    </admin-layout>
</template>

<script>
import UserDocumentsMatrix from "@/Components/Pages/Admin/UserDocument/Index/UserDocumentsMatrix";
import AdminLayout from "@/Layouts/AdminLayout";
import {ref} from "vue";
export default {
    name: 'Index',
    components: {AdminLayout, UserDocumentsMatrix},
    props: {
        user_documents: Object
    },
    setup(props, context) {
        const breadcrumbs = ref([
            { name: 'User Documents', url: window.location.pathname },
        ]);

        return {
            breadcrumbs
        };
    },
}
</script>

<style scoped>

</style>
