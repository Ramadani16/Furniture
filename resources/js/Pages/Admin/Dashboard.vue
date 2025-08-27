<!-- resources/js/Pages/Admin/Dashboard.vue -->
<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>
    <p>{{ message }}</p>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({
  message: String
})
</script>
