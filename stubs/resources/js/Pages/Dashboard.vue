<script setup lang="ts">
import { defineProps } from 'vue'

// Properties provided by the controller
defineProps({
  message: String
})

</script>

<template>
    <div>
        <h1 class="bg-red-500">Dashboard</h1>
        <p> {{ message }} </p>
    </div>
</template>