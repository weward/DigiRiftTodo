<template>
    <div class="bg-brown-lighten-4 pa-5">
        
        <v-text-field
            v-model="entity.task"
            :loading="entity.loading"
            density="compact"
            variant="solo"
            label="Add New Task"
            append-inner-icon="mdi-plus-circle"    
            single-line
            hide-details
            @keyup.enter="addTask"
            @click:append-inner="addTask"
        ></v-text-field>

    </div>
</template>

<script setup>

const entity = reactive({
    task: '',
    loading: false,
})

const taskStore = useTaskStore()

const addTask = async() => {
    // request object
    let input = await entity.task.trim()

    if (input) {
        let res = await taskStore.createTaskApi(input)

        if (res) {
            entity.task = await ''
        }
    }
}

</script>