<template>
    <h1>Hi</h1>
    {{ title }}
    {{ venue }}
    {{ start }}
    {{ end }}
</template>

<script>
export default {
    name: 'Show',
    props: [
        'title',
        'venue',
        'start',
        'end',
    ]
}
</script>

<style scoped>

</style>
