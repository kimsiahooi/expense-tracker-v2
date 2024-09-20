<template>
  <section class="min-h-screen py-5 flex flex-col justify-center items-center">
    <div class="container mx-auto">
      <div class="max-w-96 mx-auto">
        <Card>
          <CardHeader>
            <CardTitle>Login</CardTitle>
          </CardHeader>
          <CardContent>
            <form @submit.prevent="loginHandler">
              <div class="mb-5 space-y-5">
                <div>
                  <label class="mb-2 block text-black" for="email">Your Email:</label>
                  <Input
                    class="text-black"
                    :class="{
                      'border-destructive': form.errors.email,
                    }"
                    type="email"
                    v-model="form.email" />
                  <p v-if="form.errors.email" class="text-destructive">{{ form.errors.email }}</p>
                </div>
                <div>
                  <label class="mb-2 block text-black" for="password">Your Password:</label>
                  <Input
                    class="text-black"
                    :class="{
                      'border-destructive': form.errors.password,
                    }"
                    type="password"
                    v-model="form.password" />
                  <p v-if="form.errors.password" class="text-destructive">{{ form.errors.password }}</p>
                </div>
              </div>
              <Button type="submit" :disabled="form.processing">
                <Loader2
                  class="w-4 h-4 mr-2 animate-spin"
                  :class="{
                    hidden: !form.processing,
                  }" />
                Submit
              </Button>
            </form>
          </CardContent>
        </Card>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Loader2 } from 'lucide-vue-next'
import { useForm } from '@inertiajs/vue3'

import { useToast } from 'primevue/usetoast'

const toast = useToast()

const form = useForm({
  email: '',
  password: '',
})

const loginHandler = () => {
  form.post(route('sign_in.login'), {
    onSuccess: ({
      props: {
        flash: { message },
      },
    }) => {
      if (message) {
        toast.add({
          severity: message.variant || 'info',
          summary: message.title,
          detail: message.description,
          life: 3000,
        })
      }
    },
  })
}
</script>
