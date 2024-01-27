<template>
    <v-list>
        <v-list-item value="notifications">
            <template v-slot:prepend="{ isActive }">

            <v-list-item-action start>
                <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
            </v-list-item-action>
            </template>

            <v-list-item-title>
                Notifications
            </v-list-item-title>

            <template v-slot:append>
                <v-btn
                    color="red-lighten-1"
                    icon="mdi-delete"
                    variant="text"
                ></v-btn>
            </template>
        </v-list-item>
    </v-list>
</template>

