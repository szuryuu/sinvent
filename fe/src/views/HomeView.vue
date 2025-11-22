<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <div class="flex flex-col gap-2 justify-center items-center">
    <h1>Login Dulu Sir</h1>
    <RouterLink to="/login" class="border bg-neutral-600 p-3 rounded-2xl text-white"
      >login</RouterLink
    >
  </div>
</template>
