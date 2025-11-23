<script setup>
import BaseHeader from '@/components/BaseHeader.vue'
import BaseTable from '@/components/BaseTable.vue'
import BasePagination from '@/components/BasePagination.vue'
import { ref, onMounted, computed, watch } from 'vue'
import { toast } from 'vue-sonner'

import api from '@/lib/axios'

const inventories = ref([])
const products = ref([])
const members = ref([])

const currentPage = ref(1)
const perPage = ref(5)
const total = ref(0)
const from = ref(0)
const to = ref(0)

const searchQuery = ref('')

const columns = [
  { label: 'Inventaris ID', key: 'inv_code' },
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

const fieldAdd = computed(() => [
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
    const res = await api.get('/inventories', {
      params: {
        page: currentPage.value,
        per_page: perPage.value,
        search: searchQuery.value,
      },
    })

    inventories.value = res.data.data.data
    total.value = res.data.data.total
    from.value = res.data.data.from
    to.value = res.data.data.to
    currentPage.value = res.data.data.current_page
  } catch (err) {
    console.log(err)
  }
}

const loadProducts = async () => {
  try {
    const res = await api.get('/products/all')
    products.value = res.data.data.data || res.data.data
  } catch (err) {
    toast.err('Gagal memuat data produk')
    console.log('Gagal memuat data produk:', err)
  }
}

const loadMembers = async () => {
  try {
    const res = await api.get('/members/all')
    members.value = res.data.data.data || res.data.data
  } catch (err) {
    toast.err('Gagal memuat data member')
    console.log('Gagal memuat data member:', err)
  }
}

const postInventories = async (newData) => {
  try {
    const payload = {
      product_id: newData.product_id,
      serial_number: newData.serial_number,
      status: newData.status,
      member_id: newData.member_id,
    }

    await api.post('/inventories', payload)
    await loadInventories()
    toast.success('Data inventaris berhasil ditambahkan')
  } catch (err) {
    toast.error('Gagal menambahkan data', { description: 'Pastikan semua form sudah terisi' })
    console.log('Error detail:', err.response?.data)
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

    await api.put(`/inventories/${updateData.id}`, payload)
    await loadInventories()
    toast.success('Data inventaris berhasil diupdate')
  } catch (err) {
    toast.error('Gagal mengupdate data', { description: 'Pastikan semua form sudah terisi' })
    console.log('Error detail:', err.response?.data)
  }
}

const deleteInventories = async (id) => {
  try {
    await api.delete(`/inventories/${id}`)
    loadInventories()
    toast.success('Data inventaris berhasil dihapus')
  } catch (err) {
    toast.error('Gagal menghapus data')
    console.log(err)
  }
}

const handleSearch = (query) => {
  searchQuery.value = query
  currentPage.value = 1
}

watch([currentPage, perPage], () => {
  loadInventories()
})

watch(searchQuery, () => {
  loadInventories()
})

onMounted(async () => {
  await Promise.all([loadInventories(), loadProducts(), loadMembers()])
})
</script>

<template>
  <BaseHeader
    title="Data Inventaris"
    trigger-name="Tambah Data"
    :fields="fieldAdd"
    @post="postInventories"
    @search="handleSearch"
  />
  <BaseTable
    :columns="columns"
    :rows="inventories"
    :field-edit="fields"
    item-delete="product.name"
    @update="updateInventories"
    @delete="deleteInventories"
  />
  <BasePagination
    :current-page="currentPage"
    :per-page="perPage"
    :total="total"
    :from="from"
    :to="to"
    @update:current-page="(page) => (currentPage = page)"
    @update:per-page="(size) => (perPage = size)"
  />
</template>
