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
      </div>

      <!-- Navigation -->
      <nav class="flex-1 py-4">
        <ul class="space-y-2 px-2">
          <!-- Dashboard -->
          <li>
            <Link
              href="/penjual/dashboard"
              class="flex items-center p-3 rounded-lg hover:bg-gray-800 group transition-all duration-200"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400 group-hover:text-amber-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0
                     01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2
                     2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0
                     01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0
                     012 2v2a2 2 0 01-2 2H6a2 2 0
                     01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0
                     012 2v2a2 2 0 01-2 2h-2a2 2 0
                     01-2-2v-2z"
                />
              </svg>
              <span class="ml-3">Dashboard</span>
            </Link>
          </li>

          <!-- Produk -->
          <li>
            <Link
              href="/penjual/produk"
              class="flex items-center p-3 rounded-lg hover:bg-gray-800 group transition-all duration-200"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400 group-hover:text-amber-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8
                     4m0-10L4 7m8 4v10M4 7v10l8 4"
                />
              </svg>
              <span class="ml-3">Produk</span>
            </Link>
          </li>

          <!-- Data Customer -->
          <li>
            <Link
              href="/penjual/customer"
              class="flex items-center p-3 rounded-lg hover:bg-gray-800 group transition-all duration-200"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400 group-hover:text-amber-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17 20h5v-2a3 3 0
                     00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7
                     20H2v-2a3 3 0
                     015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0
                     0a5.002 5.002 0
                     019.288 0M15 7a3 3 0
                     11-6 0 3 3 0 016 0zm6 3a2 2 0
                     11-4 0 2 2 0 014 0zM7 10a2 2 0
                     11-4 0 2 2 0 014 0z"
                />
              </svg>
              <span class="ml-3">Data Customer</span>
            </Link>
          </li>

          <!-- Pesan Masuk -->
          <li>
            <Link
              href="/penjual/kontak"
              class="flex items-center p-3 rounded-lg hover:bg-gray-800 group transition-all duration-200"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400 group-hover:text-amber-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0
                     002.22 0L21 8M5 19h14a2 2 0
                     002-2V7a2 2 0
                     00-2-2H5a2 2 0
                     00-2 2v10a2 2 0
                     002 2z"
                />
              </svg>
              <span class="ml-3">Pesan Masuk</span>
            </Link>
          </li>

          <!-- Logout -->
          <li class="mt-8 pt-4 border-t border-gray-700">
            <button
              @click="logout"
              class="flex items-center w-full p-3 rounded-lg hover:bg-gray-800 group transition-all duration-200"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400 group-hover:text-amber-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6
                     4v1a3 3 0
                     01-3 3H6a3 3 0
                     01-3-3V7a3 3 0
                     013-3h4a3 3 0
                     013 3v1"
                />
              </svg>
              <span class="ml-3">Logout</span>
            </button>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'

function logout() {
  router.post('/penjual/logout')
}
</script>
