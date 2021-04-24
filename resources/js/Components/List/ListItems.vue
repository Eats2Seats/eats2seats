<template>
    <div
        v-for="(item, index) in items.data"
        :key="index"
    >
        <slot :item="item"></slot>
    </div>
    <div v-if="items.data.length === 0">
        <slot name="empty">
            <p>The list is empty.</p>
        </slot>
    </div>
</template>

<script>
const emitter = require('tiny-emitter/instance');
export default {
    name: 'ListItems',
    data () {
        return {
            items: {
                data: [],
            }
        };
    },
    mounted () {
        emitter.on('list-items-updated', (list) => {
            this.items = list;
        });
    },
    beforeUnmount () {
        emitter.off('list-items-updated');
    }
}
</script>

<style scoped>

</style>
