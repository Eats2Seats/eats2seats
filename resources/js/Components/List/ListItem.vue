<template>
    <inertia-link :href="href">
        <slot></slot>
    </inertia-link>
</template>

<script>
export default {
    name: 'ListItem',
    props: {
        href: String,
    },
}
</script>

<style scoped>

</style>
