<script setup>
import BaseCard from '@/components/BaseCard.vue'
import BaseChart from '@/components/BaseChart.vue'
import { onMounted, ref } from 'vue'
import api from '@/lib/axios'
import { toast } from 'vue-sonner'

const stats = ref({
  baik: 0,
  rusak: 0,
  dilelang: 0,
  'tidak dipakai': 0,
  total: 0,
})

const loadAnalytics = async () => {
  try {
    const res = await api.get('/inventories/all')

    const inventories = res.data.data

    const statusCount = {
      baik: 0,
      rusak: 0,
      dilelang: 0,
      'tidak dipakai': 0,
    }

    inventories.forEach((item) => {
      if (Object.hasOwn(statusCount, item.status)) {
        statusCount[item.status]++
      }
    })

    stats.value = {
      ...statusCount,
      total: inventories.length,
    }

    console.log(res.data.data)
  } catch (err) {
    toast.error('Gagal memuat data analytics')
    console.log(err)
  }
}

onMounted(() => {
  loadAnalytics()
})
</script>

<template>
  <div class="flex flex-col h-full">
    <div class="flex gap-12 w-full">
      <BaseCard icon="ClipboardCheck" title="Barang Baik" :value="stats.baik" />
      <BaseCard icon="TriangleAlert" title="Barang Rusak" :value="stats.rusak" />
      <BaseCard icon="Tag" title="Dilelang" :value="stats.dilelang" />
      <BaseCard icon="CircleX" title="Tidak Dipakai" :value="stats['tidak dipakai']" />
    </div>
    <div class="flex-1">
      <BaseChart :stats="stats" />
    </div>
  </div>
</template>
