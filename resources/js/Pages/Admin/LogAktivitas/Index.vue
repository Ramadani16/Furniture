<template>
  <div class="max-w-6xl mx-auto p-4 sm:p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Log Aktivitas</h1>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
      <table class="w-full text-sm sm:text-base">
        <thead>
          <tr class="bg-gray-50 text-gray-600">
            <th class="p-3 border text-center w-[140px]">Tanggal</th>
            <th class="p-3 border w-[150px]">Created</th>
            <th class="p-3 border text-center w-[100px]">Aksi</th>
            <th class="p-3 border text-center w-[100px]">Model</th>
            <th class="p-3 border">Detail Perubahan</th>
            <th class="p-3 border text-center w-[80px]">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr
            v-for="log in logs"
            :key="log.id"
            class="hover:bg-gray-50 border-b border-gray-100"
          >
            <td class="p-3 border text-center whitespace-nowrap">
              {{ formatDate(log.created_at) }}
            </td>

            <td class="p-3 border whitespace-nowrap">
              <span class="font-medium">{{ log.user?.name || '-' }}</span>
            </td>

            <td class="p-3 border text-center whitespace-nowrap">
              <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-full text-xs">{{ log.aksi || '-' }}</span>
            </td>

            <td class="p-3 border text-center whitespace-nowrap">
              <span class="px-2 py-1 bg-green-50 text-green-600 rounded-full text-xs">{{ log.model || '-' }}</span>
            </td>

            <td class="p-3 border">
              <div v-if="log.perubahan" class="space-y-2">
                <div
                  v-for="(change, field) in parsePerubahan(log.perubahan)"
                  :key="field"
                  class="flex flex-col"
                >
                  <span class="capitalize font-medium text-gray-600 text-xs">{{ field }}</span>

                  <!-- Harga -->
                  <template v-if="field.toLowerCase() === 'price'">
                    <div class="flex items-center gap-2">
                      <span class="line-through text-gray-400">{{ formatPrice(cleanValue(change.old)) }}</span>
                      <span class="text-gray-400">→</span>
                      <span class="font-medium text-green-600">{{ formatPrice(cleanValue(change.new)) }}</span>
                    </div>
                  </template>

                  <!-- Gambar -->
                  <template
                    v-else-if="field.toLowerCase().includes('image') || field.toLowerCase().includes('gambar') || isImage(change.old) || isImage(change.new)"
                  >
                    <div class="flex items-center gap-3">
                      <div class="flex flex-col items-center">
                        <template v-if="change.old">
                          <img
                            v-if="isImage(change.old)"
                            :src="getImageUrl(cleanValue(change.old))"
                            class="w-12 h-12 object-cover border rounded"
                            @error="handleImageError"
                          />
                          <div v-else class="w-12 h-12 bg-gray-100 border rounded flex items-center justify-center">
                            <span class="text-xs text-gray-400">{{ truncateText(cleanValue(change.old)) }}</span>
                          </div>
                          <span class="text-xs text-gray-500 mt-1">Lama</span>
                        </template>
                        <template v-else>
                          <div class="w-12 h-12 bg-gray-100 border rounded flex items-center justify-center">
                            <span class="text-xs text-gray-400">No image</span>
                          </div>
                        </template>
                      </div>

                      <span class="text-gray-400">→</span>

                      <div class="flex flex-col items-center">
                        <template v-if="change.new">
                          <img
                            v-if="isImage(change.new)"
                            :src="getImageUrl(cleanValue(change.new))"
                            class="w-12 h-12 object-cover border rounded"
                            @error="handleImageError"
                          />
                          <div v-else class="w-12 h-12 bg-gray-100 border rounded flex items-center justify-center">
                            <span class="text-xs text-gray-400">{{ truncateText(cleanValue(change.new)) }}</span>
                          </div>
                          <span class="text-xs text-gray-500 mt-1">Baru</span>
                        </template>
                        <template v-else>
                          <div class="w-12 h-12 bg-gray-100 border rounded flex items-center justify-center">
                            <span class="text-xs text-gray-400">No image</span>
                          </div>
                        </template>
                      </div>
                    </div>
                  </template>

                  <!-- Text biasa -->
                  <template v-else>
                    <div class="flex items-center gap-2">
                      <span class="text-gray-500 text-sm">"{{ cleanValue(change.old) || '-' }}"</span>
                      <span class="text-gray-400">→</span>
                      <span class="text-sm font-medium">"{{ cleanValue(change.new) || '-' }}"</span>
                    </div>
                  </template>
                </div>
              </div>
              <span v-else class="text-gray-400 text-sm">-</span>
            </td>

            <td class="p-3 border text-center">
              <button
                @click="deleteLog(log.id)"
                class="px-2 py-1 bg-red-50 text-red-600 rounded hover:bg-red-100 text-xs"
              >
                Hapus
              </button>
            </td>
          </tr>

          <tr v-if="!logs.length">
            <td colspan="6" class="text-center p-4 text-gray-500">
              Tidak ada data log aktivitas.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })

defineProps({
  logs: { type: Array, default: () => [] }
})

const parsePerubahan = (p) => {
  if (!p) return {}
  try {
    return typeof p === 'string' ? JSON.parse(p) : p
  } catch {
    return {}
  }
}

const formatDate = (dateStr) => {
  if (!dateStr) return '-'
  return new Date(dateStr).toLocaleString('id-ID', {
    day: '2-digit', month: 'short', year: 'numeric',
    hour: '2-digit', minute: '2-digit', hour12: false
  })
}

const formatPrice = (val) => {
  if (!val && val !== 0) return '-'
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(Number(val))
}

const cleanValue = (val) => {
  if (val === null || val === undefined) return ''
  if (typeof val !== 'string') return val.toString()
  return val.replace(/^"+|"+$/g, '')
}

const isImage = (val) => {
  if (!val || typeof val !== 'string') return false
  return /\.(png|jpe?g|gif|webp|svg)$/i.test(cleanValue(val))
}

const getImageUrl = (filename) => {
  if (!filename) return ''
  if (filename.startsWith('http')) return filename
  return `/storage/${filename}`
}

const handleImageError = (e) => {
  e.target.style.display = 'none'
}

const truncateText = (text, length = 10) => {
  if (!text) return ''
  return text.length > length ? text.substring(0, length) + '...' : text
}

const deleteLog = (id) => {
  if (confirm('Yakin ingin menghapus log ini?')) {
    router.delete(`/admin/logs/${id}`)
  }
}
</script>
