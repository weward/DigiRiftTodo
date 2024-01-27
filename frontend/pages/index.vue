<template>
    <div class="d-flex justify-center mb-6 bg-surface-variant h-100">
        <v-col align-self="center">
            <v-sheet class="d-flex justify-center mb-6 bg-surface-variant">
                <div class="w-25">

                    <AppLabel></AppLabel>

                    <Toolbar></Toolbar>
                    
                    <List></List>
                    
                    <InputSection></InputSection>
                    
                </div>
            </v-sheet>
        </v-col>
        
    </div>
</template>

<script setup>

    let onClick = () => {
        console.log("test add")
    }
</script>