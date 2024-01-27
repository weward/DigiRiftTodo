<template>
    <div class="bg-brown-lighten-4 pa-5">
        <v-text-field
            :loading="false"
            density="compact"
            variant="solo"
            label="Search templates"
            append-inner-icon="mdi-plus-circle"
        
            single-line
            hide-details
            @click:append-inner="onClick"
        ></v-text-field>
    </div>
</template>