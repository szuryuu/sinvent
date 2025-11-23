<script setup>
import BaseHeader from '@/components/BaseHeader.vue'
import BaseTable from '@/components/BaseTable.vue'
import { ref, onMounted } from 'vue'
import { toast } from 'vue-sonner'

import api from '@/lib/axios'

const inventories = ref([])
const loading = ref(true)

const columns = [
  { label: 'Barang', key: 'product.name' },
  { label: 'Type', key: 'product.type' },
  { label: 'Serial Number', key: 'serial_number' },
  { label: 'Spesifikasi', key: 'product.specification' },
  { label: 'Status', key: 'status' },
  { label: 'Assign', key: 'member.name' },
  { label: 'Department', key: 'member.department' },
]

const fields = [
  { label: 'Inventaris ID', key: 'id', span: 2, readonly: true },
  { label: 'Barang', key: 'product.name', span: 2 },
  { label: 'Type', key: 'product.type', span: 2, readonly: true },
  { label: 'Serial Number', key: 'serial_number', span: 2 },
  { label: 'Spesifikasi', key: 'product.specification', span: 2, readonly: true },
  {
    label: 'Status',
    key: 'status',
    span: 2,
    type: 'select',
    options: [
      { label: 'Baik', value: 'baik' },
      { label: 'Rusak', value: 'rusak' },
      { label: 'Dilelang', value: 'dilelang' },
      { label: 'Tidak Dipakai', value: 'tidak dipakai' },
    ],
  },
  { label: 'Assign', key: 'member.name', span: 1 },
  { label: 'Department', key: 'member.department', span: 1, readonly: true },
]

const loadInventories = async () => {
  try {
    const res = await api.get('/inventories')
    inventories.value = res.data.data.data
    console.log('data:', inventories)
  } finally {
    loading.value = true
  }
}

const updateInventories = async (updateData) => {
  try {
    await api.put(`/inventories/${updateData.id}`, updateData)
    toast.success('sip')
    await loadInventories()
  } catch (err) {
    toast.error('gagal')
    console.log(err)
  }
}

const deleteInventories = async (id) => {
  try {
    await api.delete(`/inventories/${id}`)
    toast.success('Hapus data berhasil')
    loadInventories()
  } catch (err) {
    console.log(err)
  }
}

onMounted(() => {
  loadInventories()
})
</script>

<template>
  <BaseHeader title="Data Inventaris" trigger-name="Tambah Data" />
  <BaseTable
    :columns="columns"
    :rows="inventories"
    :field-edit="fields"
    item-delete="product.name"
    @update="updateInventories"
    @delete="deleteInventories"
  />
</template>
