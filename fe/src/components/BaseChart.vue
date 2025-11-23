<script setup>
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'
import { ref, watch } from 'vue'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const props = defineProps({
  stats: {
    type: Object,
    required: true,
  },
})

const chartData = ref({
  labels: ['Baik', 'Rusak', 'Dilelang', 'Tidak Dipakai'],
  datasets: [
    {
      label: 'Jumlah Barang',
      data: [],
      backgroundColor: ['#4F46E5', '#EF4444', '#F59E0B', '#6B7280'],
    },
  ],
})

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
})

watch(
  () => props.stats,
  (newStats) => {
    chartData.value.datasets[0].data = [
      newStats.baik,
      newStats.rusak,
      newStats.dilelang,
      newStats['tidak dipakai'],
    ]
  },
  { deep: true, immediate: true },
)
</script>

<template>
  <Bar :options="chartOptions" :data="chartData" />
</template>
