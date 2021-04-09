<template>

</template>

<script>
export default {
    name: 'Show',
    props: {
        event: {
            required: true,
            type: Object,
            validator: (event) => {
                return typeof event['id'] === 'number'
                    && typeof event['title'] === 'string'
                    && !isNaN(Date.parse(event['start']))
                    && !isNaN(Date.parse(event['end']));
            },
        },
        venue: {
            required: true,
            type: Object,
            validator: (venue) => {
                return typeof venue['name'] === 'string'
                    && typeof venue['street'] === 'string'
                    && typeof venue['city'] === 'string'
                    && typeof venue['state'] === 'string'
                    && typeof venue['zip'] === 'string'
            },
        },
        reservations: {
            required: true,
            type: Array,
            validator: (reservations) => reservations.every((reservation) => {
                return typeof reservation === 'object'
                    && typeof reservation['id'] === 'number'
                    && typeof reservation['stand_name'] === 'string'
                    && typeof reservation['position_type'] === 'string'
                    && typeof reservation['location'] === 'string'
            }),
        }
    }
}
</script>

<style scoped>

</style>
