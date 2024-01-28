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
})


watch(() => entity.selected, async(updatedSelected) => {
        // update task
        entity.tasks = await entity.tasks.map((elem) => 
            elem = {
                ...elem, 
                status: (entity.selected.includes(elem.id)) ? true : false
            }
        )    
        // update store
        await taskStore.updateTasks(entity.tasks)
        await localStorage.setItem('selectedTasks', JSON.stringify(updatedSelected))
    }
)

const fetchAll = async () => {
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
    
    await taskStore.updateTasks(entity.tasks)
}

onMounted(() => {
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