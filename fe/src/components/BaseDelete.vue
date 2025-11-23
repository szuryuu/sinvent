<script setup>
const emit = defineEmits(['delete'])

defineProps({
  item: {
    type: String,
    required: true,
  },
  purpose: {
    type: String,
  },
})

import { Trash } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Dialog, DialogClose, DialogContent, DialogTrigger } from '@/components/ui/dialog'
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button
        variant="default"
        class="text-white capitalize text-left bg-neutral-900 cursor-pointer"
      >
        Delete
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px] [&>button:last-child]:hidden rounded-4xl p-10">
      <div class="flex flex-col gap-3 items-center justify-center text-center">
        <div class="p-4 my-1 bg-rose-600 rounded-2xl"><Trash size="28" color="white" /></div>
        <h1 class="font-semibold">Delete Data</h1>
        <span class="text-gray-500"
          >Are you sure you want to delete {{ purpose || '' }}
          <span class="font-semibold text-black">{{ item }}</span
          >? This action cannot be undone.</span
        >
      </div>
      <Button
        @click="emit('delete')"
        type="submit"
        class="bg-rose-600 hover:bg-rose-700 p-7 rounded-2xl cursor-pointer"
      >
        Delete Data
      </Button>
      <DialogClose as-child>
        <Button variant="ghost" class="cursor-pointer p-7"> Cancel </Button>
      </DialogClose>
    </DialogContent>
  </Dialog>
</template>
