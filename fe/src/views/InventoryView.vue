<script setup>
import BaseHeader from '@/components/BaseHeader.vue'
import BaseTable from '@/components/BaseTable.vue'
import { ref, onMounted } from 'vue'
import api from '@/lib/axios'

const inventories = ref([])
const loading = ref(true)

const columns = [
  { label: 'Product ID', key: 'product_id' },
  { label: 'Member ID', key: 'member_id' },
  { label: 'Serial Number', key: 'serial_number' },
  { label: 'Status', key: 'status' },
]

const loadInventory = async () => {
  try {
    const res = await api.get('/inventories')
    inventories.value = res.data.data.data
    console.log('data:', inventories)
  } finally {
    loading.value = true
  }
}

onMounted(() => {
  loadInventory()
})
</script>

<template>
  <BaseHeader title="Data Inventaris" trigger-name="Tambah Data" />
  <BaseTable :columns="columns" :rows="inventories" />
</template>
