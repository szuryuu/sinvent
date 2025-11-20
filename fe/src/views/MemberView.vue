<script setup>
import { Ellipsis } from 'lucide-vue-next'

import HeaderTable from '@/components/HeaderTable.vue'
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

const members = [
  {
    id: 'INV001',
    name: 'Paid',
    position: '$250.00',
    departement: 'Credit Card',
  },
]
</script>

<template>
  <HeaderTable title="Management Anggota" trigger-name="Tambah Anggota" />
  <main>
    <Table>
      <TableHeader>
        <TableRow>
          <TableHead class="w-[100px]"> No </TableHead>
          <TableHead>Nama</TableHead>
          <TableHead>Jabatan</TableHead>
          <TableHead>Departement</TableHead>
          <TableHead class="text-right capitalize"> action </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="member in members" :key="member.id">
          <TableCell class="font-medium">
            {{ member.id }}
          </TableCell>
          <TableCell>{{ member.name }}</TableCell>
          <TableCell>{{ member.position }}</TableCell>
          <TableCell>{{ member.departement }}</TableCell>
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
  </main>
</template>
