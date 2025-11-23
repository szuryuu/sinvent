<script setup>
import { onMounted, ref, watch } from 'vue'
import BaseHeader from '@/components/BaseHeader.vue'
import BaseTable from '@/components/BaseTable.vue'
import BasePagination from '@/components/BasePagination.vue'
import { toast } from 'vue-sonner'

import api from '@/lib/axios'

const members = ref([])

const currentPage = ref(1)
const perPage = ref(5)
const total = ref(0)
const from = ref(0)
const to = ref(0)

const searchQuery = ref('')

const columns = [
  { label: 'Nama', key: 'name' },
  { label: 'Jabatan', key: 'position' },
  { label: 'Department', key: 'department' },
]

const fields = [
  { label: 'Nama', key: 'name', span: 2 },
  { label: 'Jabatan', key: 'position', span: 2 },
  {
    label: 'Department',
    key: 'department',
    span: 2,
    type: 'select',
    options: [
      { label: 'IT', value: 'IT' },
      { label: 'HR', value: 'HR' },
      { label: 'Finance', value: 'Finance' },
    ],
  },
]

const loadMembers = async () => {
  try {
    const res = await api.get('/members', {
      params: {
        page: currentPage.value,
        per_page: perPage.value,
        search: searchQuery.value,
      },
    })

    members.value = res.data.data.data
    total.value = res.data.data.total
    from.value = res.data.data.from
    to.value = res.data.data.to
    currentPage.value = res.data.data.current_page

    // toast.success('Data anggota berhasil dimuat')
  } catch (err) {
    toast.error('Gagal memuat data')
    console.log(err)
  }
}

const postMembers = async (newData) => {
  try {
    const payload = {
      name: newData.name,
      position: newData.position,
      department: newData.department,
    }

    await api.post('/members', payload)
    toast.success('Data anggota berhasil ditambahkan')
    await loadMembers()
  } catch (err) {
    toast.error('Gagal menambahkan data')
    console.log(err)
  }
}

const updateMembers = async (updatedData) => {
  try {
    await api.put(`/members/${updatedData.id}`, updatedData)
    toast.success('sukses')
    await loadMembers()

    toast.success('Data anggota berhasil diupdate')
  } catch (err) {
    toast.error('Gagal mengupdate data')
    console.log(err)
  }
}

const deleteMembers = async (id) => {
  try {
    await api.delete(`/members/${id}`)
    loadMembers()

    toast.success('Data anggota berhasil dihapus')
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
  loadMembers()
})

watch(searchQuery, () => {
  loadMembers()
})

onMounted(() => {
  loadMembers()
})
</script>

<template>
  <BaseHeader
    title="Management Anggota"
    trigger-name="Tambah Anggota"
    :fields="fields"
    @post="postMembers"
    @search="handleSearch"
  />
  <BaseTable
    :columns="columns"
    :rows="members"
    :field-edit="fields"
    item-delete="name"
    delete-purpose="member"
    @update="updateMembers"
    @delete="deleteMembers"
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
