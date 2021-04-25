<template>
    {{ formattedDate }}
</template>

<script>
export default {
    name: 'FormattedDate',
    props: {
        date: {
            type: String,
            required: true,
        }
    },
    computed: {
        formattedDate () {
            let dateObj = new Date(this.date);
            let dateStr = dateObj.toLocaleDateString('en-US', {
                day: 'numeric',
                weekday: 'short',
                month: 'long',
                ...(new Date().getFullYear() !== dateObj.getFullYear() && { year: 'numeric'}),
            });
            let timeStr = dateObj.toLocaleTimeString('en-US', {
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
            });
            return `${dateStr} @ ${timeStr}`;
        }
    }
}
</script>

<style scoped>

</style>
