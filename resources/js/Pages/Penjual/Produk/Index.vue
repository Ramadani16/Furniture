<template>
  <PenjualLayout>
    <div class="p-6 bg-white rounded-lg shadow">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Produk</h2>
        <Link 
          href="/penjual/produk/create" 
          class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center gap-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Tambah Produk
        </Link>
      </div>

      <div class="flex flex-col md:flex-row gap-6">
        <!-- Filter Sidebar -->
        <div class="w-full md:w-64 bg-gray-50 p-4 rounded-lg border border-gray-200">
          <h3 class="font-medium text-lg mb-4 text-gray-700">Filter Produk</h3>
          
          <!-- Search -->
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
            <input
              v-model="searchTerm"
              type="text"
              placeholder="Nama produk..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
            >
          </div>

          <!-- Category Filter -->
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select
              v-model="selectedCategory"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
            >
              <option value="">Semua Kategori</option>
              <option value="furniture">Furniture</option>
              <option value="elektronik">Elektronik</option>
              <option value="bazar">Bazar</option>
            </select>
          </div>

          <!-- Price Range -->
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Harga</label>
            <div class="flex items-center gap-2 mb-2">
              <input
                v-model="minPrice"
                type="number"
                placeholder="Min"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
              >
              <span class="text-gray-500">-</span>
              <input
                v-model="maxPrice"
                type="number"
                placeholder="Max"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
              >
            </div>
          </div>

          <button
            @click="resetFilters"
            class="w-full mt-2 px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm"
          >
            Reset Filter
          </button>
        </div>

        <!-- Table -->
        <div class="flex-1 overflow-x-auto">
          <vue-good-table
            :columns="columns"
            :rows="filteredProducts"
            :search-options="{ enabled: false }"
            :pagination-options="{
              enabled: true,
              perPage: 4,
              nextLabel: 'Selanjutnya',
              prevLabel: 'Sebelumnya',
              rowsPerPageLabel: 'Item per halaman',
              ofLabel: 'dari',
              allLabel: 'Semua'
            }"
            style-class="vgt-table striped"
          >
            <template #table-row="props">
              <!-- Kolom Gambar -->
              <template v-if="props.column.field === 'image'">
                <img 
                  v-if="props.row.image" 
                  :src="'/storage/' + props.row.image" 
                  class="w-12 h-12 object-cover rounded border"
                />
                <span v-else class="text-gray-400 text-sm">No image</span>
              </template>

              <!-- Kolom Aksi -->
              <template v-else-if="props.column.field === 'actions'">
                <div class="flex space-x-3">
                  <Link 
                    :href="`/penjual/produk/${props.row.id}/edit`" 
                    class="text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </Link>
                  <button 
                    @click="hapusProduk(props.row.id)" 
                    class="text-red-600 hover:text-red-800 transition-colors flex items-center gap-1"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                  </button>
                </div>
              </template>

              <!-- Kolom Harga -->
              <template v-else-if="props.column.field === 'price'">
                Rp {{ Number(props.row.price).toLocaleString('id-ID') }}
              </template>

              <!-- Kolom Default -->
              <template v-else>
                {{ props.formattedRow[props.column.field] }}
              </template>
            </template>
          </vue-good-table>
        </div>
      </div>
    </div>
  </PenjualLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import PenjualLayout from '@/Layouts/PenjualLayout.vue'
import { VueGoodTable } from 'vue-good-table-next'
import { ref, computed } from 'vue'

const props = defineProps({
  products: Array
})

// Filter states
const searchTerm = ref('')
const selectedCategory = ref('')
const minPrice = ref('')
const maxPrice = ref('')

// Columns definition
const columns = [
  {
    label: 'Nama Produk',
    field: 'name',
    sortable: true
  },
  {
    label: 'Kategori',
    field: 'category',
    sortable: true
  },
  {
    label: 'Harga',
    field: 'price',
    sortable: true,
    type: 'number'
  },
  {
    label: 'Gambar',
    field: 'image',
    sortable: false
  },
  {
    label: 'Aksi',
    field: 'actions',
    sortable: false
  }
]

// Computed filtered products
const filteredProducts = computed(() => {
  return props.products.filter(product => {
    // Search filter
    const matchesSearch = product.name.toLowerCase().includes(searchTerm.value.toLowerCase())
    
    // Category filter
    const matchesCategory = selectedCategory.value === '' || product.category === selectedCategory.value
    
    // Price range filter
    const price = Number(product.price)
    const matchesMinPrice = minPrice.value === '' || price >= Number(minPrice.value)
    const matchesMaxPrice = maxPrice.value === '' || price <= Number(maxPrice.value)
    
    return matchesSearch && matchesCategory && matchesMinPrice && matchesMaxPrice
  })
})

// Reset all filters
const resetFilters = () => {
  searchTerm.value = ''
  selectedCategory.value = ''
  minPrice.value = ''
  maxPrice.value = ''
}

const hapusProduk = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
    router.delete(`/penjual/produk/${id}`)
  }
}
</script>

<style>
@import 'vue-good-table-next/dist/vue-good-table-next.css';

/* Custom styling */
.vgt-table.striped {
  width: 100%;
  border-collapse: collapse;
}

.vgt-table.striped th {
  @apply bg-gray-100 text-left px-4 py-3 text-sm font-medium text-gray-700 uppercase tracking-wider;
}

.vgt-table.striped td {
  @apply px-4 py-3 border-t border-gray-200 text-sm text-gray-700;
}

.vgt-table.striped tr:hover td {
  @apply bg-gray-50;
}

.vgt-wrap__footer {
  @apply px-4 py-3 border-t border-gray-200;
}
</style>