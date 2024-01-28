
<template>
    <div>
        <v-toolbar
        class=""
        density="comfortable"
        :elevation="8"
        title=""
        >
        <div class="w-100 d-flex justify-end">
            
            <TodoButton></TodoButton>
            
            <DoneButton></DoneButton>

            <DeleteAllTodo v-show="tasksTodo?.length"></DeleteAllTodo>

            <DeleteAllDone v-show="tasksDone?.length"></DeleteAllDone>

        </div>
    </v-toolbar>
</div>
</template>

<script setup>

const taskStore = useTaskStore()

const data = reactive({
    tasks: [],
})

const tasksDone = computed(() => data.tasks?.filter((elem) => elem.status == true))
const tasksTodo = computed(() => data.tasks?.filter((elem) => elem.status == false))

watch(() => taskStore.tasks, async (newVal) => {
    data.tasks = await JSON.parse(newVal)
})

</script>