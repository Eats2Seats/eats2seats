<template>
<<<<<<< HEAD
    <div class="bg-white rounded shadow">
        <div
            class="p-6"
            v-if="hasHeader"
        >
            <slot name="header"></slot>
        </div>
        <div
            class="border-gray-300"
            :class="[
                hasHeader ? 'rounded-none border-t' : 'rounded-t border-t-0',
                hasFooter ? 'rounded-none border-b' : 'rounded-b border-b-0',
                hasHeader || hasFooter ? 'py-4 bg-gray-50' : 'py-6 bg-white'
            ]"
        >
            <slot name="body"></slot>
        </div>
        <div
            class="p-6"
            v-if="hasFooter"
        >
            <slot name="footer"></slot>
        </div>
=======
    <div class="p-6 bg-white shadow">
        <slot></slot>
>>>>>>> b15afa96c3ecc2c66df935458865f1493f50359c
    </div>
</template>

<script>
export default {
    name: 'Card',
}
</script>

<style scoped>

</style>
