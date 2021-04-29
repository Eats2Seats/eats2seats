<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 bg-white">
                        <slot></slot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'MatrixTable',
    components: {},
    props: {},
    setup(props, context) {

        return {};
    },
}
</script>

<style scoped>

</style>
