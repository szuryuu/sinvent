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
      data: [0, 0, 0, 0],
      backgroundColor: ['#7138E9'],

      borderRadius: {
        topLeft: 14,
        topRight: 14,
        bottomLeft: 0,
        bottomRight: 0,
      },
      borderSkipped: 'bottom',
    },
  ],
})

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    y: {
      beginAtZero: true,
      suggestedMax: 8,
    },
  },
})

watch(
  () => props.stats,
  (newStats) => {
    chartData.value.datasets[0].data = [
      newStats.baik ?? 0,
      newStats.rusak ?? 0,
      newStats.dilelang ?? 0,
      newStats['tidak dipakai'] ?? 0,
    ]
  },
  { deep: true, immediate: true },
)

console.log(props.stats)
</script>

<template>
  <Bar :options="chartOptions" :data="chartData" />
</template>
