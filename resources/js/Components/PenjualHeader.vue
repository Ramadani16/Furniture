<template>
  <header class="h-16 bg-white shadow-md flex items-center justify-between px-6 sticky top-0 z-10">
    <!-- Left Side -->
    <div class="flex items-center">
      
      <h1 class="text-xl font-semibold text-gray font-serif">
        <slot name="title">Dashboard Penjual</slot>
      </h1>
    </div>

    <!-- Right Side -->
    <div class="flex items-center space-x-4">
      <!-- Notification -->
      <button
        class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200 relative"
        aria-label="Notifikasi"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span
          v-if="hasNotification"
          class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-500"
        ></span>
      </button>

      <!-- User Profile -->
      <div class="relative" ref="userMenuRef">
        <button
          @click="toggleUserMenu"
          class="flex items-center space-x-2 focus:outline-none"
        >
          <div
            class="h-8 w-8 rounded-full bg-gradient-to-r from-gray-400 to-gray-600 flex items-center justify-center text-white font-medium"
          >
            {{ penjualInitial }}
          </div>
        </button>

        <!-- Dropdown -->
        <div
          v-if="showUserMenu"
          class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
        >
          <div class="px-4 py-2 border-b">
            <p class="text-sm font-medium">{{ penjualName }}</p>
            <p class="text-xs text-gray-500">{{ penjualEmail }}</p>
          </div>
          <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
         
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed, ref, onMounted, onBeforeUnmount } from 'vue'

const page = usePage()
const penjual = computed(() => page.props.auth?.penjual || {})

const penjualInitial = computed(() => penjual.value?.name?.charAt(0)?.toUpperCase() || 'P')
const penjualName = computed(() => penjual.value?.name || 'Penjual')
const penjualEmail = computed(() => penjual.value?.email || 'email@domain.com')

const hasNotification = ref(true) // bisa diganti sesuai data dari backend
const showUserMenu = ref(false)
const userMenuRef = ref(null)

function toggleUserMenu() {
  showUserMenu.value = !showUserMenu.value
}

function logoutPenjual() {
  fetch('/penjual/logout', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
  }).then(() => {
    window.location.href = '/penjual/login'
  })
}

function handleClickOutside(e) {
  if (userMenuRef.value && !userMenuRef.value.contains(e.target)) {
    showUserMenu.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
