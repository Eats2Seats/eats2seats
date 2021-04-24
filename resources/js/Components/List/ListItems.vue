<template>
    <div
        v-for="(item, index) in $parent.$props.items.data"
        :key="index"
    >
        <slot :item="item"></slot>
    </div>
</template>

<script>
export default {
    name: 'ListItems',
}
</script>

<style scoped>

</style>
