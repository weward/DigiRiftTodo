<template>
    <v-chip
        size="small"
        class="ma-2"
        color="gray">
        <template v-slot:prepend>
            <v-badge
                color="grey"
                :content="count"
                inline
            ></v-badge>
        </template>
        Done
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