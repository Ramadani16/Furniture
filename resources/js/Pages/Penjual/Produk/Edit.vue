<template>
  <div class="max-w-4xl mx-auto py-10">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
      <h1 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
         Edit Produk
      </h1>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- Nama Produk -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
          <input
            type="text"
            v-model="form.name"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            placeholder="Masukkan nama produk..."
          />
          <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
        </div>

        <!-- Kategori -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
          <select
            v-model="form.category"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
          >
            <option value="">Pilih Kategori</option>
            <option value="furniture">Furniture</option>
            <option value="elektronik">Elektronik</option>
            <option value="bazar">Bazar</option>
          </select>
          <p v-if="form.errors.category" class="text-red-500 text-sm mt-1">{{ form.errors.category }}</p>
        </div>

        <!-- Harga -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
          <div class="relative">
            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
            <input
              type="number"
              v-model="form.price"
              class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
              placeholder="Masukkan harga..."
            />
          </div>
          <p v-if="form.errors.price" class="text-red-500 text-sm mt-1">{{ form.errors.price }}</p>
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
          <textarea
            v-model="form.description"
            rows="4"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            placeholder="Tuliskan deskripsi produk..."
          ></textarea>
          <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <!-- Foto -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
          <input
            type="file"
            @change="handleFileChange"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                   file:rounded-lg file:border-0 file:text-sm file:font-semibold
                   file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
          />
          <p v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</p>

          <div v-if="produk.image" class="mt-4">
            <p class="text-sm text-gray-600">Foto saat ini:</p>
            <img
              :src="`/storage/${produk.image}`"
              alt="Foto Produk"
              class="w-40 rounded-lg mt-2 border border-gray-200 shadow-sm"
            />
          </div>
        </div>

        <!-- Tombol Submit -->
        <div class="pt-4">
          <button
            type="submit"
            class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition"
          >
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import PenjualLayout from '@/Layouts/PenjualLayout.vue'

defineOptions({
  layout: PenjualLayout
})

const props = defineProps({
  produk: Object
})

const form = useForm({
  name: props.produk.name || '',
  category: props.produk.category || '',
  price: props.produk.price || '',
  description: props.produk.description || '',
  image: null,
  _method: 'put' // taruh di body form, bukan di opsi
})

const handleFileChange = (e) => {
  form.image = e.target.files[0]
}

const submit = () => {
  form.post(`/penjual/produk/${props.produk.id}`, {
    preserveScroll: true,
    forceFormData: true
  })
}
</script>

