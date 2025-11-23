<script setup>
import BaseHeader from '@/components/BaseHeader.vue'
import BaseTable from '@/components/BaseTable.vue'
import { ref, onMounted, computed } from 'vue'
import { toast } from 'vue-sonner'

import api from '@/lib/axios'

const inventories = ref([])
const products = ref([])
const members = ref([])
const loading = ref(true)

const columns = [
  { label: 'Inventaris ID', key: 'id' },
  { label: 'Barang', key: 'product.name' },
  { label: 'Type', key: 'product.type' },
  { label: 'Serial Number', key: 'serial_number' },
  { label: 'Spesifikasi', key: 'product.specification' },
  { label: 'Status', key: 'status' },
  { label: 'Assign', key: 'member.name' },
  { label: 'Department', key: 'member.department' },
]

const productOptions = computed(() =>
  products.value.map((p) => ({
    label: p.name,
    value: p.id,
    data: p,
  })),
)

const memberOptions = computed(() =>
  members.value.map((m) => ({
    label: m.name,
    value: m.id,
    data: m,
  })),
)

const fieldPost = [
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

const fields = computed(() => [
  { label: 'Inventaris ID', key: 'id', span: 2, readonly: true },
  {
    label: 'Barang',
    key: 'product_id',
    span: 2,
    type: 'select',
    options: productOptions.value,
    onChange: (selectedOption, formData) => {
      formData.product = {
        name: selectedOption.data.name,
        type: selectedOption.data.type,
        specification: selectedOption.data.specification,
      }
    },
  },
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
  {
    label: 'Assign',
    key: 'member_id',
    span: 1,
    type: 'select',
    options: memberOptions.value,
    onChange: (selectedOption, formData) => {
      formData.member = {
        name: selectedOption.data.name,
        department: selectedOption.data.department,
      }
    },
  },
  { label: 'Department', key: 'member.department', span: 1, readonly: true },
])

const loadInventories = async () => {
  try {
    const res = await api.get('/inventories')
    inventories.value = res.data.data.data
    console.log('data:', inventories)
  } finally {
    loading.value = true
  }
}

const loadProducts = async () => {
  try {
    const res = await api.get('/products')
    products.value = res.data.data.data || res.data.data
    console.log('Products:', products.value)
  } catch (err) {
    console.error('Gagal memuat data produk:', err)
  }
}

const loadMembers = async () => {
  try {
    const res = await api.get('/members')
    members.value = res.data.data.data || res.data.data
    console.log('Members:', members.value)
  } catch (err) {
    console.error('Gagal memuat data member:', err)
  }
}

const updateInventories = async (updateData) => {
  try {
    const payload = {
      product_id: updateData.product_id,
      serial_number: updateData.serial_number,
      status: updateData.status,
      member_id: updateData.member_id,
    }

    console.log('Sending payload:', payload)

    await api.put(`/inventories/${updateData.id}`, payload)
    toast.success('Berhasil update data inventaris')
    await loadInventories()
  } catch (err) {
    toast.error('Gagal update data inventaris')
    console.error('Error detail:', err.response?.data)
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

onMounted(async () => {
  await Promise.all([loadInventories(), loadProducts(), loadMembers()])
})
</script>

<template>
  <BaseHeader title="Data Inventaris" trigger-name="Tambah Data" :fields="fieldPost" />
  <BaseTable
    :columns="columns"
    :rows="inventories"
    :field-edit="fields"
    item-delete="product.name"
    @update="updateInventories"
    @delete="deleteInventories"
  />
</template>
