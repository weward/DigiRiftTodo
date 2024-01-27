<template>
    <v-chip
        class="ma-2"
        color="amber">
        <template v-slot:prepend>
            <v-badge
                color="warning"
                content="6"
                inline
                class="pa-1"
            ></v-badge>
        </template>
        Todo
    </v-chip>
</template>