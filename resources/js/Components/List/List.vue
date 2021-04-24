<template>
    <slot></slot>
</template>

<script>
export default {
    name: 'List',
    props: {
        items: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            required: false,
        }
    }
}
</script>

<style scoped>

</style>
