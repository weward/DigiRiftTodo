<template>
    <v-list>

        <v-list-item v-for="task in entity.tasks" :key="task.id" class="list-item">
                    
            <template v-slot:prepend>
                <v-list-item-action start>
                    <v-checkbox-btn 
                        v-model="entity.selected"
                        :value="task.id"
                    ></v-checkbox-btn>
                </v-list-item-action>
            </template>

            <v-list-item-title>
                <span :class="{'text-decoration-line-through text-disabled': task.status}">{{ task.name }}</span>
            </v-list-item-title>

            <template v-slot:append>
                <v-hover>
                    <template v-slot:default="{ isHovering, props }">
                        <v-btn
                            class="hover-btn"
                                v-bind="props"
                            :color="isHovering ? 'red-lighten-1' : 'brown-lighten-5'"
                            icon="mdi-delete"
                            variant="text"
                        ></v-btn>
                    </template>
                </v-hover>
            </template>
            
    </v-list-item>

</v-list>
</template>

<script setup>
import { onMounted, reactive } from 'vue'

const taskStore = useTaskStore()

const entity = reactive({
    tasks: [],
    selected: [],
    doneLoading: false,
})

const updateSelected = async (updatedSelected, oldSelected) => {
    // execute only after first load
    if  (!entity.doneLoading) {
        return
    }

    let taskId = await (updatedSelected.length > oldSelected.length) 
        ? updatedSelected.filter(id => !oldSelected.includes(id))
        : oldSelected.filter(id => !updatedSelected.includes(id))

    taskId = await taskId[0] ?? false

    if (taskId) {
        entity.tasks = await entity.tasks.map((elem) =>
            elem = {
                ...elem,
                status: (elem.id==taskId) ? !elem.status : elem.status
            }
        )
        
        const query = await gql`
            mutation updateTask ($TASK_ID: ID!) {
                updateTask(id: $TASK_ID) {
                    id
                    name
                    status
                }
            }
        `
        // compose variable
        const variables = await {
            TASK_ID: taskId
        }
        // form mutation
        const { mutate } = await useMutation(query, { variables })
        // send to api
        const { data } = await mutate(variables)
        if (data.updateTask) {
            // Update store state
            let tasks = await taskStore.getTasks

            await taskStore.updateTasks([...tasks, data.updateTask])
        }
    }
}


watch(() => taskStore.tasks, async (updatedTasks) => {
    // update locacl state whenever the store gets updated
    entity.tasks =  await updatedTasks
})

// whenever a checkbox is checked
watch(() => entity.selected, (newVal, oldVal) => updateSelected(newVal, oldVal))


const fetchAll = async () => {
    entity.doneLoading = await false
    // request object
    const query = await gql`
        {
            tasks {
                id,
                name,
                status
            }
        }
    ` 
    // request and response
    const { data } = await useAsyncQuery(query)
    // populate list
    entity.tasks = await data?.value?.tasks
    // set selected
    entity.selected = await entity.tasks.filter((elem) => elem.status == true).map((elem) => elem.id)
    // update store
    await taskStore.updateTasks(entity.tasks)

    entity.doneLoading = await true
}

onMounted(() => {
    // fetch all from server
    fetchAll()
})

</script>

<style>
.hover-btn {
  transition: transform 0.3s;
}

.list-item:hover {
    background-color: #f0f0f0;
}
</style>