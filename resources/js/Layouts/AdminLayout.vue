<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <AdminSidebar :is-collapsed="isSidebarCollapsed" />

    <!-- Main Content -->
    <div
      class="flex-1 flex flex-col transition-all duration-300"
      :class="isSidebarCollapsed ? 'ml-20' : 'ml-64'"
    >
      <AdminHeader
        :is-sidebar-collapsed="isSidebarCollapsed"
        @toggle-sidebar="toggleSidebar"
      />

      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AdminSidebar from '@/Components/AdminSidebar.vue'
import AdminHeader from '@/Components/AdminHeader.vue'

const isSidebarCollapsed = ref(false)

function toggleSidebar() {
  isSidebarCollapsed.value = !isSidebarCollapsed.value
}
</script>
