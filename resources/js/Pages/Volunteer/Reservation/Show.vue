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
                return typeof event['title'] === 'string'
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
                    && typeof venue['zip'] === 'string';
            },
        },
        reservation: {
            required: true,
            type: Object,
            validator: (reservation) => {
                return typeof reservation['id'] === 'number'
                    && typeof reservation['stand_name'] === 'string'
                    && typeof reservation['stand_location'] === 'string'
                    && typeof reservation['position_type'] === 'string';
            }
        }
    }
}
</script>

<style scoped>

</style>
