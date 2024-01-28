<template>
    <v-chip
        size="small"
        class="ma-2"
        color="green">
        <template v-slot:prepend>
            <v-badge
                color="success"
                :content="count"
                inline
            ></v-badge>
        </template>
        Todo
    </v-chip>
</template>

<script setup>

const props = defineProps({
    count: {
        required: true,
        default: 0
    }
})

</script>