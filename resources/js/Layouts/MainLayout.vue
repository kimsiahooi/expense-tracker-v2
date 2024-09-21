<template>
  <header class="py-3 shadow fixed top-0 left-0 w-full z-50 bg-white">
    <div class="container mx-auto">
      <div class="flex items-center justify-between">
        <Link class="font-semibold text-xl" :href="route('index')">Exp. Tracker</Link>

        <div class="flex items-center">
          <div class="leading-none inline-block">
            <DropdownMenu v-if="user">
              <DropdownMenuTrigger>
                <Avatar>
                  <AvatarImage
                    :src="`https://ui-avatars.com/api/?name=${user.name.split(' ').join('+')}`"
                    alt="avatar" />
                  <AvatarFallback>{{ user.name }}</AvatarFallback>
                </Avatar>
              </DropdownMenuTrigger>
              <DropdownMenuContent>
                <DropdownMenuLabel>My Account</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                  <Link :href="route('sign_out')" method="DELETE" as="button" class="flex items-center w-full">
                    <LogOut class="w-3.5 h-3.5 mr-2" /> Sign out
                  </Link>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>

          <div v-if="!user">
            <Button as-child>
              <Link :href="route('sign_in')">Sign In</Link>
            </Button>
          </div>
        </div>
      </div>
    </div>
  </header>
  <main class="py-24 min-h-screen flex flex-col">
    <slot />
  </main>
  <Toast pt:root:class="max-w-[calc(100%-40px)]" />
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { Link } from '@inertiajs/vue3'
import { LogOut } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'

const page = usePage()

const user = computed(() => page.props.user)
</script>
