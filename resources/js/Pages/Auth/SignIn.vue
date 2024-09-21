<template>
  <section class="flex-1 flex flex-col items-center justify-center">
    <div class="container mx-auto">
      <div class="max-w-96 mx-auto">
        <Card>
          <CardHeader>
            <CardTitle>Sign In</CardTitle>
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
              <Button type="submit" :disabled="form.processing" class="w-full">
                <Loader2
                  class="w-4 h-4 mr-2 animate-spin"
                  :class="{
                    hidden: !form.processing,
                  }" />
                Sign In
              </Button>
              <div class="mt-5">
                <p class="text-sm text-slate-600">
                  No Account yet? <Link :href="route('sign_up')" class="underline">Sign Up</Link>
                </p>
              </div>
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
import { Link } from '@inertiajs/vue3'

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
