<script setup>
defineProps({
  title: {
    type: String,
    required: true,
  },
  triggerName: {
    type: String,
    required: true,
  },
  fields: {
    type: Array,
    required: true,
  },
})

import { SearchIcon, ListFilter } from 'lucide-vue-next'

import BaseAdd from './BaseAdd.vue'
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from '@/components/ui/input-group'
</script>

<template>
  <header class="px-1.5 flex justify-between items-center mb-4">
    <h1 class="font-semibold">{{ title }}</h1>
    <div class="flex gap-2">
      <InputGroup class="bg-slate-200 py-6 px-2 rounded-2xl">
        <InputGroupInput placeholder="Search Anggota" />
        <InputGroupAddon>
          <SearchIcon />
        </InputGroupAddon>
        <InputGroupAddon align="inline-end">
          <InputGroupButton>
            <ListFilter />
          </InputGroupButton>
        </InputGroupAddon>
      </InputGroup>

      <BaseAdd :trigger="triggerName" :fields="fields" />
    </div>
  </header>
</template>
