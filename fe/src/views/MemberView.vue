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
  { label: 'Nama', key: 'name', placeholder: 'Mas A', span: 2 },
  { label: 'Jabatan', key: 'position', placeholder: 'Programmer', span: 2 },
  { label: 'Department', key: 'department', placeholder: 'IT', span: 2 },
]

const loadMembers = async () => {
  try {
    const res = await api.get('/members')
    members.value = res.data.data.data
  } finally {
    loading.value = false
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
    item-delete="name"
    delete-purpose="member"
    @delete="deleteMembers"
  />
</template>
