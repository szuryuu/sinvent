<script setup>
import { Info } from 'lucide-vue-next'
import * as Icons from 'lucide-vue-next'
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'

const props = defineProps({
  icon: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  value: {
    type: Number,
  },
})

const IconComponent = Icons[props.icon]
</script>

<template>
  <Card class="w-full bg-neutral-50 border-0 rounded-4xl">
    <CardHeader>
      <CardTitle class="flex justify-between">
        <div class="bg-gray-200 p-2 rounded-lg">
          <component :is="IconComponent" class="w-5 h-5" />
        </div>
        <div class="bg-gray-200 p-2 rounded-lg">
          <Info class="w-5 h-5" />
        </div>
      </CardTitle>
    </CardHeader>
    <CardContent>
      <p>{{ title }}</p>
    </CardContent>
    <CardFooter>
      <p class="text-2xl font-semibold">{{ value }}</p>
    </CardFooter>
  </Card>
</template>
