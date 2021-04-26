<template>
    <tbody class="bg-white divide-y divide-gray-200">
        <tr
            v-for="row in matrix.data"
            :key="row.id"
            class="even:bg-gray-50"
        >
            <slot :row="row"></slot>
        </tr>
    </tbody>
</template>

<script>
const emitter = require('tiny-emitter/instance');

export default {
    name: 'MatrixDataBody',
    components: {},
    props: {},
    data() {
        return {
            matrix: {
                data: []
            }
        };
    },
    mounted () {
        emitter.on('matrix-data-updated', (matrix) => this.matrix = matrix);
    },
    beforeUnmount () {
        emitter.off('matrix-data-updated');
    }
}
</script>

<style scoped>

</style>
