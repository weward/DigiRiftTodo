<template>
    <div class="text-center">

        <v-dialog v-model="data.open" width="360" persistent>
            <v-card>
                <v-card-title>Please Confirm</v-card-title>
                <v-card-text class="mb-4">
                    Do you reall want to <i>proceed?</i>
                </v-card-text>
                <v-card-actions class="d-flex justify-space-between bg-surface-light">
                    <v-btn color="success" @click="onProceed">Proceed</v-btn>
                    <v-btn color="error"  @click="onCancel">Cancel</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        
    </div>
</template>

<script setup>
    const props = defineProps({
        open: {
            required: true,
            default: false,
        },
        payloadType: {
            required: true,
            type: String
        },
        payload: {
            required: true,
            type: Boolean
        }
    })

    const data = reactive({
        open: false,
    })

    const emit = defineEmits(['onProceed', 'onCancel'])

    const onProceed = () => {
        emit('onProceed', props.payloadType, props.payload)
        data.open = false
    }

    const onCancel = () => {
        data.open = false
        emit('onCancel')
    }

    watch(() => props.open, (newVal) => {
        data.open = newVal
    })

</script>