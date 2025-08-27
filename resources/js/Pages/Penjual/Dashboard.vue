<!-- resources/js/Pages/Admin/Dashboard.vue -->
<template>
  <PenjualLayout>
    <h1 class="text-2xl font-bold mb-4">Dashboard Penjual</h1>
    <p>{{ message }}</p>
    
  </PenjualLayout>
</template>

<script setup>
import PenjualLayout from '@/Layouts/PenjualLayout.vue';

defineProps({
  message: String
})
</script>
