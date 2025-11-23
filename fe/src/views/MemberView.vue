<script setup>
import { onMounted, ref } from 'vue'
import BaseHeader from '@/components/BaseHeader.vue'
import BaseTable from '@/components/BaseTable.vue'
import { toast } from 'vue-sonner'

import api from '@/lib/axios'

const members = ref([])
const loading = ref(true)

const selectedItem = ref(null)

const columns = [
  { label: 'Nama', key: 'name' },
  { label: 'Jabatan', key: 'position' },
  { label: 'Department', key: 'department' },
]

const fields = [
  { label: 'Nama', key: 'name', defaultValue: 'Mas A', span: 2 },
  { label: 'Jabatan', key: 'position', defaultValue: 'Programmer', span: 2 },
  {
    label: 'Department',
    key: 'department',
    span: 2,
    type: 'select',
    options: [
      { label: 'IT', value: 1 },
      { label: 'HR', value: 2 },
      { label: 'Finance', value: 3 },
    ],
  },
]

const loadMembers = async () => {
  try {
    const res = await api.get('/members')
    members.value = res.data.data.data
  } finally {
    loading.value = false
  }
}

const updateMembers = async (updatedData) => {
  try {
    await api.put(`/members/${updatedData.id}`, updatedData)

    toast.success('sukses')
  } catch (err) {
    toast.error('Gagal..')
    console.log(err)
  }
}

const deleteMembers = async (id) => {
  try {
    await api.delete(`/members/${id}`)
    toast.success('Hapus data berhasil')
    loadMembers()
  } catch (err) {
    console.log(err)
  }
}

const handleUpdate = (updatedData) => {
  updateMembers(updatedData)
}

onMounted(() => {
  loadMembers()
})
</script>

<template>
  <BaseHeader title="Management Anggota" trigger-name="Tambah Anggota" :fields="fields" />
  <BaseTable
    :columns="columns"
    :rows="members"
    :field-edit="fields"
    item-delete="name"
    delete-purpose="member"
    @delete="deleteMembers"
  />
</template>
