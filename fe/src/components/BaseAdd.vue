<script setup>
import { Plus } from 'lucide-vue-next'
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

const props = defineProps({
  trigger: {
    type: String,
    required: true,
  },
  fields: {
    type: Array,
    required: true,
  },
})
const emit = defineEmits(['post'])

const formData = ref({})
const isOpen = ref(false)

function getNestedValue(obj, path) {
  return path.split('.').reduce((acc, part) => acc?.[part], obj)
}

function setNestedValue(obj, path, value) {
  const keys = path.split('.')
  const lastKey = keys.pop()
  const target = keys.reduce((acc, key) => {
    if (!acc[key]) acc[key] = {}
    return acc[key]
  }, obj)
  target[lastKey] = value
}

watch(isOpen, (newVal) => {
  if (newVal) {
    formData.value = {}

    props.fields.forEach((field) => {
      if (!field.readonly) {
        setNestedValue(formData.value, field.key, field.defaultValue || '')
      }
    })
  }
})

const handleFieldChange = (field, value) => {
  setNestedValue(formData.value, field.key, value)

  if (field.onChange) {
    const selectedOption = field.options?.find((opt) => opt.value === value)
    if (selectedOption) {
      field.onChange(selectedOption, formData.value)
    }
  }
}

const handleSubmit = () => {
  emit('post', formData.value)
  isOpen.value = false
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button
        variant="default"
        class="flex items-center justify-center py-6 px-8 rounded-2xl cursor-pointer"
      >
        <Plus /> {{ trigger }}
      </Button>
    </DialogTrigger>
    <DialogContent
      class="sm:max-w-[800px] rounded-4xl p-10 [&>button:last-child]:bg-neutral-300 [&>button:last-child]:p-2 [&>button:last-child]:rounded-lg [&>button:last-child]:cursor-pointer"
    >
      <DialogHeader>
        <DialogTitle>{{ trigger }}</DialogTitle>
        <DialogDescription
          >Fill out the form below to add new data. Make sure everything looks right before
          saving.</DialogDescription
        >
      </DialogHeader>
      <form @submit.prevent="handleSubmit">
        <div class="grid grid-cols-2 gap-4 pb-4">
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
                :disabled="field.readonly"
                :model-value="getNestedValue(formData, field.key)"
                @update:model-value="(val) => handleFieldChange(field, val)"
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
                class="h-16 pt-6 bg-slate-200 rounded-2xl"
                :disabled="field.readonly"
                :model-value="getNestedValue(formData, field.key)"
                @update:model-value="(val) => setNestedValue(formData, field.key, val)"
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
          <Button type="submit" class="cursor-pointer"> Save changes </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
