<template>
    <div class="bg-brown-lighten-4 pa-5">
        
        <v-text-field
            v-model="entity.task"
            :loading="entity.loading"
            density="compact"
            variant="solo"
            label="Search templates"
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
        const query = await gql`
            mutation createTask ($INPUT: String!) {
                createTask(name: $INPUT) {
                    id
                    name
                    status
                }
            }
        `
        const variables = await {
            INPUT: input
        }
        // form mutation
        const { mutate } = await useMutation(query, { variables })
        // send to api
        const { data } = await mutate(variables)
        // append to list
        let tasks = await taskStore.getTasks

        await tasks.push(data.createTask)
        await taskStore.updateTasks(tasks)

        entity.task = await ''
    }
}

</script>