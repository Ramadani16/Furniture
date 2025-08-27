<template>
  <aside
    class="fixed top-0 left-0 h-screen bg-gray-900 text-white transition-all duration-300 ease-in-out overflow-hidden"
    :class="isCollapsed ? 'w-20' : 'w-64'"
  >
    <div class="flex flex-col h-full">
      <!-- Logo/Title -->
      <div class="flex items-center justify-center h-16 px-4 border-b border-gray-800">
        <h2 v-if="!isCollapsed" class="text-xl font-bold text-white font-serif">
  Furniture
</h2>

        <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          class="h-8 w-8 text-amber-500"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"
          />
        </svg>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 py-4">
        <ul class="space-y-2 px-2">
          <li v-for="item in menuItems" :key="item.href">
            <Link
              :href="item.href"
              class="flex items-center p-3 rounded-lg hover:bg-gray-800 group transition-all duration-200"
            >
              <component
                :is="item.icon"
                class="h-5 w-5 text-gray-400 group-hover:text-amber-400"
              />
              <span
                v-if="!isCollapsed"
                class="ml-3 whitespace-nowrap"
              >
                {{ item.label }}
              </span>
            </Link>
          </li>

          <!-- Logout -->
          <li class="mt-8 pt-4 border-t border-gray-700">
            <button
              @click="logout"
              class="flex items-center w-full p-3 rounded-lg hover:bg-gray-800 group transition-all duration-200"
            >
              <LogoutIcon
                class="h-5 w-5 text-gray-400 group-hover:text-amber-400"
              />
              <span
                v-if="!isCollapsed"
                class="ml-3 whitespace-nowrap"
              >
                Logout
              </span>
            </button>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import {
  Squares2X2Icon,
  CubeIcon,
  UsersIcon,
  ClipboardDocumentListIcon,
  EnvelopeIcon,
  ArrowRightOnRectangleIcon as LogoutIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  isCollapsed: Boolean
})

const menuItems = [
  { label: 'Dashboard', href: '/admin/dashboard', icon: Squares2X2Icon },
  { label: 'Produk', href: '/admin/produk', icon: CubeIcon },
  { label: 'Data Customer', href: '/admin/customer', icon: UsersIcon },
  { label: 'Data Penjual', href: '/admin/penjual', icon: UsersIcon },
  { label: 'Log Aktivitas', href: '/admin/log-aktivitas', icon: ClipboardDocumentListIcon },
  { label: 'Pesan Masuk', href: '/admin/kontak', icon: EnvelopeIcon }
]

function logout() {
  router.post('/admin/logout')
}
</script>
