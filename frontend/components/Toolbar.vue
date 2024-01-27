
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

            <DeleteAllTodo></DeleteAllTodo>

            <DeleteAllDone></DeleteAllDone>

        </div>
    </v-toolbar>
</div>
</template>

<script setup>


</script>