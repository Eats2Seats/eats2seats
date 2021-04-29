<template>
    <MenuItem
        as="div"
        class="cursor-pointer hover:bg-gray-50"
    >
        <div class="px-4 py-3">
            <slot as="div"></slot>
        </div>
    </MenuItem>
</template>

<script>
import {MenuItem} from "@headlessui/vue";

export default {
    name: 'MatrixRowActionItem',
    components: {MenuItem},
    props: {},
    setup(props, context) {

        return {};
    },
}
</script>

<style scoped>

</style>
