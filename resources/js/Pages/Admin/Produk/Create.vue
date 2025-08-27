<template>
  <AdminLayout>
    <div class="p-6 bg-white rounded-lg shadow">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h2>
        <Link 
          href="/admin/produk" 
          class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors flex items-center gap-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Kembali
        </Link>
      </div>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- Nama Produk -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
          <input
            v-model="form.name"
            type="text"
            id="name"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            :class="{ 'border-red-500': errors.name }"
          >
          <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
        </div>

        <!-- Kategori -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
          <div class="grid grid-cols-3 gap-3">
            <label 
              v-for="category in categories" 
              :key="category.value"
              class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50"
              :class="{ 'border-blue-500 bg-blue-50': form.category === category.value }"
            >
              <input
                v-model="form.category"
                type="radio"
                :value="category.value"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
              >
              <span class="ml-2 text-sm text-gray-700">{{ category.label }}</span>
            </label>
          </div>
          <p v-if="errors.category" class="mt-1 text-sm text-red-600">{{ errors.category }}</p>
        </div>

        <!-- Harga -->
        <div>
          <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
          <div class="relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <span class="text-gray-500">Rp</span>
            </div>
            <input
              v-model="form.price"
              type="number"
              id="price"
              min="0"
              step="1000"
              class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              :class="{ 'border-red-500': errors.price }"
            >
          </div>
          <p v-if="errors.price" class="mt-1 text-sm text-red-600">{{ errors.price }}</p>
        </div>

        <!-- Deskripsi -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
          <textarea
            v-model="form.description"
            id="description"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          ></textarea>
        </div>

        <!-- Gambar -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
          <div class="mt-1 flex items-center">
            <div v-if="previewImage" class="mr-4">
              <img :src="previewImage" class="w-32 h-32 object-cover rounded-md border">
            </div>
            <div class="flex items-center">
              <label for="image" class="cursor-pointer">
                <div class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  {{ form.image ? 'Ganti Gambar' : 'Pilih Gambar' }}
                </div>
                <input 
                  id="image" 
                  type="file" 
                  class="sr-only" 
                  @change="handleImageChange"
                  accept="image/*"
                >
              </label>
              <button 
                v-if="form.image" 
                @click="removeImage" 
                type="button" 
                class="ml-2 px-4 py-2 bg-red-100 border border-transparent rounded-md shadow-sm text-sm font-medium text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
              >
                Hapus
              </button>
            </div>
          </div>
          <p v-if="errors.image" class="mt-1 text-sm text-red-600">{{ errors.image }}</p>
          <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG (Maks. 2MB)</p>
        </div>

        <!-- Tombol Submit -->
        <div class="pt-4 border-t border-gray-200">
          <button 
            type="submit" 
            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            :disabled="processing"
          >
            <span v-if="!processing">Simpan Produk</span>
            <span v-else class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Memproses...
            </span>
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'

const props = defineProps({
  errors: Object
})

const categories = [
  { value: 'furniture', label: 'Furniture' },
  { value: 'elektronik', label: 'Elektronik' },
  { value: 'bazar', label: 'Bazar' }
]

const form = ref({
  name: '',
  category: '',
  price: '',
  description: '',
  image: null
})

const previewImage = ref(null)
const processing = ref(false)

const handleImageChange = (e) => {
  const file = e.target.files[0]
  if (file) {
    // Validasi ukuran file (max 2MB)
    if (file.size > 2048 * 1024) {
      alert('Ukuran file terlalu besar. Maksimal 2MB')
      return
    }
    
    // Validasi tipe file
    if (!file.type.match('image.*')) {
      alert('File harus berupa gambar')
      return
    }
    
    form.value.image = file
    
    // Buat preview gambar
    const reader = new FileReader()
    reader.onload = (e) => {
      previewImage.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const removeImage = () => {
  form.value.image = null
  previewImage.value = null
}

const submit = () => {
  processing.value = true
  
  // Konversi data ke FormData untuk upload file
  const formData = new FormData()
  formData.append('name', form.value.name)
  formData.append('category', form.value.category)
  formData.append('price', form.value.price)
  formData.append('description', form.value.description)
  if (form.value.image) {
    formData.append('image', form.value.image)
  }
  
  router.post('/admin/produk', formData, {
    onFinish: () => {
      processing.value = false
    },
    preserveScroll: true
  })
}
</script>