<script setup>
import { ref } from 'vue'

const perPage = ref('1')

import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination'
</script>

<template>
  <div class="flex justify-between pt-6 items-center">
    <div class="flex gap-2 justify-center items-center">
      <span>Showing</span>
      <Select v-model="perPage">
        <SelectTrigger class="w-18">
          <SelectValue placeholder="..." />
        </SelectTrigger>
        <SelectContent>
          <SelectGroup>
            <SelectItem v-for="n in [5, 10, 15]" :key="n" :value="String(n)">
              {{ n }}
            </SelectItem>
          </SelectGroup>
        </SelectContent>
      </Select>
      <span class="text-gray-400 lowercase">Item per page</span>
    </div>

    <div class="flex flex-col gap-6">
      <Pagination v-slot="{ page }" :items-per-page="10" :total="30" :default-page="2">
        <PaginationContent v-slot="{ items }">
          <PaginationPrevious />

          <template v-for="(item, index) in items" :key="index">
            <PaginationItem
              v-if="item.type === 'page'"
              :value="item.value"
              :is-active="item.value === page"
            >
              {{ item.value }}
            </PaginationItem>
          </template>

          <PaginationEllipsis :index="4" />

          <PaginationNext />
        </PaginationContent>
      </Pagination>
    </div>
  </div>
</template>
