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
})

import { SearchIcon, ListFilter, Plus } from 'lucide-vue-next'

import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
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
        <DialogTrigger>
          <Button class="flex items-center justify-center py-6 px-8 rounded-2xl">
            <Plus /> {{ triggerName }}
          </Button>
        </DialogTrigger>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Are you absolutely sure?</DialogTitle>
            <DialogDescription>
              This action cannot be undone. This will permanently delete your account and remove
              your data from our servers.
            </DialogDescription>
          </DialogHeader>
        </DialogContent>
      </Dialog>
    </div>
  </header>
</template>
