<template>
    <v-chip
        class="ma-2"
        color="green">
        <template v-slot:prepend>
            <v-badge
                color="success"
                :content="count"
                inline
                class="pa-1"
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