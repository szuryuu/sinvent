<script setup>
defineProps({
  columns: {
    type: Array,
    required: true,
  },
  rows: {
    type: Array,
    required: true,
  },
})

import { Ellipsis } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'

function getCell(row, key) {
  if (!key.includes('.')) return row[key]

  return key.split('.').reduce((acc, part) => {
    return acc?.[part] ?? null
  }, row)
}
</script>

<template>
  <Table>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[100px]"> No </TableHead>
        <TableHead v-for="col in columns" :key="col.key">
          {{ col.label }}
        </TableHead>
        <TableHead class="text-right capitalize"> action </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="(row, index) in rows" :key="row.id">
        <TableCell class="font-medium">
          {{ index + 1 }}
        </TableCell>
        <TableCell v-for="col in columns" :key="col.key"> {{ getCell(row, col.key) }}</TableCell>

        <!-- Action -->
        <TableCell class="text-right">
          <Popover>
            <PopoverTrigger as-child>
              <Button variant="outline">
                <Ellipsis />
              </Button>
            </PopoverTrigger>
            <PopoverContent class="w-auto bg-neutral-900">
              <div class="grid gap-2">
                <Button
                  variant="default"
                  class="text-white capitalize text-left bg-neutral-900 cursor-pointer"
                >
                  edit</Button
                >
                <Button
                  variant="default"
                  class="text-white capitalize text-left bg-neutral-900 cursor-pointer"
                  >delete</Button
                >
              </div>
            </PopoverContent>
          </Popover>
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>
