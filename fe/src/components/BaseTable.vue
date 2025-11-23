<script setup>
import { Ellipsis } from 'lucide-vue-next'
import BaseDelete from './BaseDelete.vue'
import BaseEdit from './BaseEdit.vue'
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

const emit = defineEmits(['delete', 'update'])

defineProps({
  columns: {
    type: Array,
    required: true,
  },
  rows: {
    type: Array,
    required: true,
  },
  itemDelete: {
    type: String,
    required: true,
  },
  deletePurpose: {
    type: String,
  },
  fieldEdit: {
    type: Array,
    required: true,
  },
})

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
            <PopoverContent class="w-auto bg-neutral-900 rounded-3xl p-2">
              <div class="grid gap-2">
                <BaseEdit
                  :fields="fieldEdit"
                  :item="row"
                  @update="(data) => emit('update', data)"
                />
                <BaseDelete
                  :item="getCell(row, itemDelete)"
                  :purpose="deletePurpose"
                  @delete="emit('delete', row.id)"
                />
              </div>
            </PopoverContent>
          </Popover>
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>
