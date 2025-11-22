<script setup>
import { onMounted, ref } from 'vue'
import BaseHeader from '@/components/BaseHeader.vue'
import BaseTable from '@/components/BaseTable.vue'

import api from '@/lib/axios'

const members = ref([])
const loading = ref(true)

const columns = [
  { label: 'Nama', key: 'name' },
  { label: 'Jabatan', key: 'position' },
  { label: 'Department', key: 'department' },
]

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
  <BaseTable :columns="columns" :rows="members" />
</template>
