
<template>
    <div>
        
        <v-toolbar
            class=""
            density="comfortable"
            :elevation="8"
            title="">
            <div class="w-100 d-flex justify-center">

                <TodoButton :count="tasksTodo?.length"></TodoButton>
                
                <DoneButton :count="tasksDone?.length"></DoneButton>

                <DeleteAllTodo 
                    @click="deleteAll('status', false)"
                    v-show="tasksTodo?.length">
                </DeleteAllTodo>

                <DeleteAllDone 
                    @click="deleteAll('status', true)"
                    v-show="tasksDone?.length">
                </DeleteAllDone>

            </div>
        </v-toolbar>

        <ConfirmDialog 
            :open="data.confirmDialog"
            :payloadType="data.payloadType"
            :payload="data.payload"
            @onProceed="deleteAllTasks"
            @onCancel="data.confirmDialog = false"
        ></ConfirmDialog>
    </div>
</template>

<script setup>

const taskStore = useTaskStore()

const data = reactive({
    tasks: [],
    confirmDialog: false,
    payloadType: '',
    payload: '',
})

const deleteAll = (type, payload) => {
    data.payloadType = type
    data.payload = payload
    data.confirmDialog = true
}

const deleteAllTasks = (type, payload) => {
    data.confirmDialog = false
    taskStore.deleteTaskApi(type, payload)
}

const tasksDone = computed(() => data.tasks?.filter((elem) => elem.status == true))
const tasksTodo = computed(() => data.tasks?.filter((elem) => elem.status == false))

watch(() => taskStore.tasks, async (newVal) => {
    data.tasks = await newVal
})

</script>