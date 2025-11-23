<script setup>
import { computed, watch } from 'vue'

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

const props = defineProps({
  currentPage: {
    type: Number,
    default: 1,
  },
  perPage: {
    type: Number,
    default: 5,
  },
  total: {
    type: Number,
    default: 0,
  },
  from: {
    type: Number,
    default: 0,
  },
  to: {
    type: Number,
    default: 0,
  },
})

const emit = defineEmits(['update:perPage', 'update:currentPage'])

const localPerPage = computed({
  get: () => String(props.perPage),
  set: (value) => emit('update:perPage', Number(value)),
})

// const totalPages = computed(() => Math.ceil(props.total / props.perPage))

watch(
  () => props.perPage,
  () => {
    emit('update:currentPage', 1)
  },
)
</script>

<template>
  <div class="flex justify-between pt-6 items-center">
    <div class="flex gap-2 justify-center items-center">
      <span>Showing</span>
      <Select v-model="localPerPage">
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
      <Pagination
        v-slot="{ page }"
        :items-per-page="perPage"
        :total="total"
        :sibling-count="1"
        :page="currentPage"
        show-edges
        @update:page="(newPage) => emit('update:currentPage', newPage)"
      >
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
            <PaginationEllipsis v-else :index="index" />
          </template>

          <PaginationNext />
        </PaginationContent>
      </Pagination>
    </div>
  </div>
</template>
