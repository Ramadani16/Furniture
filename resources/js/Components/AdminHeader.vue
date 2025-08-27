<template>
  <header class="h-16 bg-white shadow-md flex items-center justify-between px-6 sticky top-0 z-10">
    <!-- Left Side - Toggle & Title -->
    <div class="flex items-center">
      <button
        @click="$emit('toggle-sidebar')"
        class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200 mr-4"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <h1 class="text-xl font-semibold text-gray font-serif">
        <slot name="title">Dashboard Admin</slot>
      </h1>
    </div>

    <!-- Right Side - Controls -->
    <div class="flex items-center space-x-4">
      <!-- Notification Bell -->
      <button class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200 relative">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-500"></span>
      </button>

      <!-- User Profile -->
      <div class="relative">
        <button @click="toggleUserMenu" class="flex items-center space-x-2 focus:outline-none">
          <div
            class="h-8 w-8 rounded-full bg-gradient-to-r from-gray-400 to-gray-600 flex items-center justify-center text-white font-medium">
            A
          </div>
        </button>

        <!-- Dropdown Menu -->
        <div
          v-if="showUserMenu"
          class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
        >
          <div class="px-4 py-2 border-b">
            <p class="text-sm font-medium">Admin User</p>
            <p class="text-xs text-gray-500">admin@example.com</p>
          </div>
          <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
          
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'

const showUserMenu = ref(false)

function toggleUserMenu() {
  showUserMenu.value = !showUserMenu.value
}

function logoutAdmin() {
  fetch('/admin/logout', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
  }).then(() => {
    window.location.href = '/admin/login'
  })
}
</script>
