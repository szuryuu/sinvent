<script setup>
import { RouterLink, RouterView, useRoute } from 'vue-router'
import { computed, ref } from 'vue'
import { ListChecks, UsersRound, ChartSpline } from 'lucide-vue-next'

import 'vue-sonner/style.css'
import { Toaster } from '@/components/ui/sonner'

const route = useRoute()
const showSidebar = computed(() => {
  return route.meta.layout === 'sidebar'
})

// Menu items.
const items = [
  {
    title: 'Data Inventaris',
    url: '/inventory',
    icon: ListChecks,
  },
  {
    title: 'Management Anggota',
    url: '/member',
    icon: UsersRound,
  },
  {
    title: 'Analytics',
    url: '/analytics',
    icon: ChartSpline,
  },
]

import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarHeader,
  SidebarInset,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarProvider,
  SidebarRail,
  SidebarTrigger,
} from '@/components/ui/sidebar'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

const user = ref({
  name: 'shadcn',
  email: 'm@example.com',
})

const logout = () => {
  localStorage.removeItem('token')
  window.location.href = '/login'
}
</script>

<template>
  <SidebarProvider v-if="showSidebar">
    <Sidebar>
      <SidebarHeader>
        <SidebarMenu>
          <SidebarMenuItem>
            <SidebarMenuButton size="xl">
              <div
                class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground"
              >
                <GalleryVerticalEnd class="size-4" />
              </div>
              <div class="grid flex-1 text-left leading-none pl-2">
                <span class="truncate text-xs text-neutral-400 lowercase">Managemen</span>
                <span class="truncate text-xl lowercase text-black font-semibold">Inventaris.</span>
              </div>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarHeader>
      <SidebarContent>
        <SidebarGroup>
          <SidebarGroupContent>
            <SidebarMenu>
              <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton as-child class="py-6 px-6 rounded-2xl">
                  <RouterLink :to="item.url">
                    <component :is="item.icon" />
                    <span>{{ item.title }}</span>
                  </RouterLink>
                </SidebarMenuButton>
              </SidebarMenuItem>
            </SidebarMenu>
          </SidebarGroupContent>
        </SidebarGroup>
      </SidebarContent>
      <SidebarFooter>
        <SidebarMenu>
          <SidebarMenuItem>
            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <SidebarMenuButton size="lg">
                  <img src="https://picsum.photos/200" class="w-8 h-8 rounded-lg" />
                  <div class="grid flex-1 text-left leading-none">
                    <span class="font-medium">{{ user.name }}</span>
                    <span class="text-xs text-muted-foreground">{{ user.email }}</span>
                  </div>
                </SidebarMenuButton>
              </DropdownMenuTrigger>
              <DropdownMenuContent>
                <DropdownMenuItem @click="logout"> Logout </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarFooter>
      <SidebarRail />
    </Sidebar>
    <SidebarInset>
      <header
        class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12"
      >
        <div class="flex items-center gap-2 px-4">
          <SidebarTrigger class="-ml-1" />
        </div>
      </header>
      <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
        <div class="min-h-screen flex-1 md:min-h-min p-4">
          <RouterView />
        </div>
      </div>
    </SidebarInset>
  </SidebarProvider>

  <div v-else class="min-h-screen flex items-center justify-center bg-gray-50">
    <RouterView />
  </div>

  <Toaster position="top-right" />
</template>
