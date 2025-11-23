<script setup>
import { onMounted, ref } from 'vue'
import BaseHeader from '@/components/BaseHeader.vue'
import BaseTable from '@/components/BaseTable.vue'
import { toast } from 'vue-sonner'

import api from '@/lib/axios'

const members = ref([])
const loading = ref(true)

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
      { label: 'IT', value: 'IT' },
      { label: 'HR', value: 'HR' },
      { label: 'Finance', value: 'Finance' },
    ],
  },
]

const loadMembers = async () => {
  try {
    const res = await api.get('/members')
    members.value = res.data.data.data
  } catch (err) {
    toast.error('gagal memuat')
    console.log(err)
  } finally {
    loading.value = false
  }
}

const updateMembers = async (updatedData) => {
  try {
    await api.put(`/members/${updatedData.id}`, updatedData)
    toast.success('sukses')
    await loadMembers()
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
    @update="updateMembers"
    @delete="deleteMembers"
  />
</template>
