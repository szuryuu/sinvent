<script setup>
const props = defineProps({
  fields: {
    type: Array,
    required: true,
  },
  item: {
    type: Object,
    required: true,
  },
  modelValue: {
    type: Object,
    default: () => ({}),
  },
})
const emit = defineEmits(['update:modelValue'])

import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { watch, ref } from 'vue'

const formData = ref({ ...props.modelValue })

;(watch(
  () => props.modelValue,
  (newVal) => {
    formData.value = { ...newVal }
  },
),
  { deep: true })

const updateValue = (key, value) => {
  formData.value[key] = value
  emit('update:modelValue', formData.value)
}

const handleSubmit = () => {
  emit('update:modelValue', formData.value)
}
</script>

<template>
  <Dialog>
    <form @submit.prevent="handleSubmit">
      <DialogTrigger as-child>
        <Button
          variant="default"
          class="text-white capitalize text-left bg-neutral-900 cursor-pointer"
        >
          Edit
        </Button>
      </DialogTrigger>
      <DialogContent
        class="sm:max-w-[425px] rounded-4xl p-10 [&>button:last-child]:bg-neutral-300 [&>button:last-child]:p-2 [&>button:last-child]:rounded-lg [&>button:last-child]:cursor-pointer"
      >
        <DialogHeader>
          <DialogTitle>Edit Data</DialogTitle>
          <DialogDescription> Make sure everything looks right before saving. </DialogDescription>
        </DialogHeader>
        <div class="grid grid-cols-2 gap-4">
          <div
            v-for="field in fields"
            :key="field.key"
            :class="[field.span === 2 ? 'col-span-2' : 'col-span-1']"
          >
            <div class="relative">
              <Select
                v-if="field.type === 'select'"
                :id="field.key"
                :name="field.key"
                :model-value="formData[field.key]"
                @update:model-value="updateValue(field.key, $event)"
              >
                <SelectTrigger class="pt-10 pb-6 bg-slate-200 rounded-2xl w-full">
                  <SelectValue :placeholder="field.placeholder || 'Select...'" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem v-for="opt in field.options" :key="opt.value" :value="opt.value">
                    {{ opt.label }}
                  </SelectItem>
                </SelectContent>
              </Select>
              <Input
                v-else
                :id="field.key"
                :name="field.key"
                :default-value="field.defaultValue || ''"
                :model-value="formData[field.key]"
                @update:model-value="updateValue(field.key, $event)"
                class="h-16 pt-6 bg-slate-200 rounded-2xl"
              />
              <Label
                :for="field.key"
                class="absolute left-3 top-2 text-gray-500 text-sm transition-all pointer-events-none"
              >
                {{ field.label }}
              </Label>
            </div>
          </div>
        </div>
        <DialogFooter>
          <DialogClose as-child>
            <Button variant="outline"> Cancel </Button>
          </DialogClose>
          <Button type="submit"> Save changes </Button>
        </DialogFooter>
      </DialogContent>
    </form>
  </Dialog>
</template>
