<template>
  <form @submit.prevent="logout" class="block w-full text-left">
    <button type="submit" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
      Keluar
    </button>
  </form>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

function logout() {
  router.post('/admin/logout')
}
</script>
