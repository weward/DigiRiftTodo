
<template>
    <div>
        <v-toolbar
        class=""
        density="comfortable"
        :elevation="8"
        title=""
        >
        <div class="w-100 d-flex justify-end">
            
            <TodoButton :count="tasksTodo?.length"></TodoButton>
            
            <DoneButton :count="tasksDone?.length"></DoneButton>

            <DeleteAllTodo 
                @click="deleteAllTasks('status', false)"
                v-show="tasksTodo?.length">
            </DeleteAllTodo>

            <DeleteAllDone 
                @click="deleteAllTasks('status', true)"
                v-show="tasksDone?.length">
            </DeleteAllDone>

        </div>
    </v-toolbar>
</div>
</template>

<script setup>

const taskStore = useTaskStore()

const data = reactive({
    tasks: [],
})

const deleteAllTasks = (type, payload) => {
    taskStore.deleteTaskApi(type, payload)
}

const tasksDone = computed(() => data.tasks?.filter((elem) => elem.status == true))
const tasksTodo = computed(() => data.tasks?.filter((elem) => elem.status == false))

watch(() => taskStore.tasks, async (newVal) => {
    data.tasks = await newVal
})

</script>