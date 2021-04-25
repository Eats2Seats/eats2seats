<template>
    <button class="p-2 md:p-3 border border-gray-200 rounded disabled:border-gray-200 disabled:ring-0 hover:border-indigo-600 hover:ring-1 hover:ring-indigo-600 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: 'XIconButton'
}
</script>

<style scoped>

</style>
