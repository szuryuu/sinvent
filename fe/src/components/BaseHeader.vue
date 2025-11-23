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

import { SearchIcon, ListFilter, Plus } from 'lucide-vue-next'

import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from '@/components/ui/input-group'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
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

      <Dialog>
        <form @submit.prevent>
          <DialogTrigger>
            <Button class="flex items-center justify-center py-6 px-8 rounded-2xl">
              <Plus /> {{ triggerName }}
            </Button>
          </DialogTrigger>
          <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
              <DialogTitle>{{ triggerName }}</DialogTitle>
              <DialogDescription>
                Add a new entry using the form below. Click save when you're done.
              </DialogDescription>
            </DialogHeader>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-4">
              <div
                class="grid gap-3"
                v-for="field in fields"
                :key="field.key"
                :class="['grid gap-2', field.span === 2 ? 'sm:col-span-2' : 'sm:col-span-1']"
              >
                <Label :for="field.name">{{ field.label }}</Label>
                <Input :id="field.key" :name="field.key" :placeholder="field.placeholder || ''" />
              </div>
            </div>
            <DialogFooter>
              <DialogClose as-child>
                <Button variant="outline"> Cancel </Button>
              </DialogClose>
              <Button type="submit"> Save </Button>
            </DialogFooter>
          </DialogContent>
        </form>
      </Dialog>
    </div>
  </header>
</template>
