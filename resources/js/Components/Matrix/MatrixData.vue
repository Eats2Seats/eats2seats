<template>
    <div class="mt-6 flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <slot></slot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MatrixData',
    components: {},
    props: {},
    data() {
        return {};
    },
}
</script>

<style scoped>

</style>
