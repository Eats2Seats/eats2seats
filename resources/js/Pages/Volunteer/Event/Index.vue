<template>

</template>

<script>
export default {
    name: 'Index',
    props: {
        next: {
            required: true,
            type: Object,
            validator: (next) => {
                return typeof next['event'] === 'object'
                    && typeof next['event']['title'] === 'string'
                    && !isNaN(Date.parse(next['event']['start']))
                    && !isNaN(Date.parse(next['event']['end']))
                    && typeof next['venue'] === 'object'
                    && typeof next['venue']['name'] === 'string'
                    && typeof next['venue']['street'] === 'string'
                    && typeof next['venue']['city'] === 'string'
                    && typeof next['venue']['state'] === 'string'
                    && typeof next['venue']['zip'] === 'string'
            },
        },
        events: {
            required: true,
            type: Array,
            validator: (events) => events.every((event) => {
                return typeof event === 'object'
                    && typeof event['id'] === 'number'
                    && typeof event['title'] === 'string'
                    && !isNaN(Date.parse(event['start']))
                    && !isNaN(Date.parse(event['end']));
            }),
        }
    }
}
</script>

<style scoped>

</style>
