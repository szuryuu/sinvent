<script setup>
import { toast } from 'vue-sonner'
import { Button } from '@/components/ui/button'
import {
  Card,
  CardAction,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import api from '@/lib/axios'
import { setToken } from '@/lib/token'
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const email = ref('')
const password = ref('')
const payload = computed(() => ({
  email: email.value,
  password: password.value,
}))

const handleSubmit = async () => {
  try {
    const res = await api.post('/login', payload.value)
    setToken(res.data.token)

    router.push('/inventory')
    toast.success('Login berhasil')
  } catch (err) {
    toast.error('Login gagal')
    console.log(err)
  }
}
</script>

<template>
  <Card class="w-full max-w-sm">
    <CardHeader>
      <CardTitle>Login to your account</CardTitle>
      <CardDescription> Enter your email below to login to your account </CardDescription>
      <CardAction>
        <Button
          variant="link"
          @click="() => toast.warning('Belum bisa sir', { description: 'Tanya admin yah..' })"
        >
          Sign Up
        </Button>
      </CardAction>
    </CardHeader>
    <CardContent>
      <form>
        <div class="grid w-full items-center gap-4">
          <div class="flex flex-col space-y-1.5">
            <Label for="email">Email</Label>
            <Input id="email" type="email" placeholder="m@example.com" v-model="email" />
          </div>
          <div class="flex flex-col space-y-1.5">
            <div class="flex items-center">
              <Label for="password">Password</Label>
              <a href="#" class="ml-auto inline-block text-sm underline"> Forgot your password? </a>
            </div>
            <Input id="password" type="password" v-model="password" />
          </div>
        </div>
      </form>
    </CardContent>
    <CardFooter class="flex flex-col gap-2">
      <Button class="w-full cursor-pointer" @click="handleSubmit"> Login </Button>
      <Button
        variant="outline"
        class="w-full"
        @click="
          () => toast.warning('Belum bisa sir', { description: 'Pake cara biasanya aja ya..' })
        "
      >
        Login with Google
      </Button>
    </CardFooter>
  </Card>
</template>
