<template>
  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-2xl font-semibold mb-6">Edit Produk (Admin)</h1>

    <form @submit.prevent="submit">
      <!-- Nama Produk -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
        <input
          type="text"
          v-model="form.name"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
        />
        <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
      </div>

      <!-- Kategori -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Kategori</label>
        <select
          v-model="form.category"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
        >
          <option value="">Pilih Kategori</option>
          <option value="furniture">Furniture</option>
          <option value="elektronik">Elektronik</option>
          <option value="bazar">Bazar</option>
        </select>
        <p v-if="form.errors.category" class="text-red-500 text-sm mt-1">{{ form.errors.category }}</p>
      </div>

      <!-- Harga -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Harga</label>
        <input
          type="number"
          v-model="form.price"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
        />
        <p v-if="form.errors.price" class="text-red-500 text-sm mt-1">{{ form.errors.price }}</p>
      </div>

      <!-- Deskripsi -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea
          v-model="form.description"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
        ></textarea>
        <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</p>
      </div>

      <!-- Foto -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Foto</label>
        <input
          type="file"
          @change="handleFileChange"
          class="mt-1 block w-full"
        />
        <p v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</p>

        <div v-if="produk.image" class="mt-4">
          <p class="text-sm text-gray-600">Foto saat ini:</p>
          <img :src="`/storage/${produk.image}`" alt="Foto Produk" class="w-40 rounded mt-2 border" />
        </div>
      </div>

      <!-- Tombol Submit -->
      <div class="mt-6">
        <button
          type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({
  layout: AdminLayout
})

const props = defineProps({
  produk: Object
})

const form = useForm({
  name: props.produk.name || '',
  category: props.produk.category || '',
  price: props.produk.price || '',
  description: props.produk.description || '',
  image: null
})

const handleFileChange = (e) => {
  form.image = e.target.files[0]
}

const submit = () => {
  form.transform((data) => ({
    ...data,
    _method: 'put'
  })).post(`/admin/produk/${props.produk.id}`, {
    preserveScroll: true,
    forceFormData: true
  })
}


</script>
