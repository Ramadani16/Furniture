<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 font-poppins">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md text-center">
      <h1 class="text-2xl font-bold text-gray-800 mb-4">Yakin ingin logout?</h1>
      <p class="text-gray-600 mb-6">Anda akan keluar dari akun penjual Anda.</p>

      <div class="flex justify-center gap-4">
        <button
          @click="logout"
          class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
        >
          Logout
        </button>
        <Link
          href="/penjual/login"
          class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
        >
          Batal
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'

function logout() {
  router.post('/penjual/logout')
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

.font-poppins {
  font-family: 'Poppins', sans-serif;
}
</style>
