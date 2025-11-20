<script setup>
import { SearchIcon, TextAlignCenter } from 'lucide-vue-next'

import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from '@/components/ui/input-group'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

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
  <header class="px-1.5 flex justify-between">
    <div>Management Anggota</div>
    <div>
      <InputGroup>
        <InputGroupInput placeholder="Search Anggota" />
        <InputGroupAddon>
          <SearchIcon />
        </InputGroupAddon>
        <InputGroupAddon align="inline-end">
          <InputGroupButton><TextAlignCenter /></InputGroupButton>
        </InputGroupAddon>
      </InputGroup>
    </div>
  </header>
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
            {{ member.departement }}
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </main>
</template>
