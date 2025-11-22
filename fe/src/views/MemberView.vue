<script setup>
import { onMounted, ref } from 'vue'
import { Ellipsis } from 'lucide-vue-next'

import BaseHeader from '@/components/BaseHeader.vue'
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

import api from '@/lib/axios'

const members = ref([])
const loading = ref(true)

const loadMembers = async () => {
  try {
    const res = await api.get('/members')
    members.value = res.data.data.data
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadMembers()
})
</script>

<template>
  <BaseHeader title="Management Anggota" trigger-name="Tambah Anggota" />
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
        <TableRow v-for="(member, index) in members" :key="member.id">
          <TableCell class="font-medium">
            {{ index + 1 }}
          </TableCell>
          <TableCell>{{ member.name }}</TableCell>
          <TableCell>{{ member.position }}</TableCell>
          <TableCell>{{ member.department }}</TableCell>
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
