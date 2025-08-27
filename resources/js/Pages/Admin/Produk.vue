<!-- resources/js/Pages/Admin/Produk.vue -->
<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>
    <table class="table-auto w-full bg-white rounded shadow">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="px-4 py-2">Nama</th>
          <th class="px-4 py-2">Kategori</th>
          <th class="px-4 py-2">Deskripsi</th>
          <th class="px-4 py-2">Harga</th>
          <th class="px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td class="px-4 py-2">{{ product.name }}</td>
          <td class="px-4 py-2">{{ product.category }}</td>
          <td class="px-4 py-2">{{ product.description }}</td>
          <td class="px-4 py-2">Rp {{ product.price.toLocaleString() }}</td>
          <td class="px-4 py-2">
            <!-- Tombol hapus -->
            <form :action="`/admin/produk/${product.id}`" method="POST" @submit.prevent="deleteProduct(product.id)">
              <input type="hidden" name="_method" value="DELETE" />
              <button type="submit" class="text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
defineProps({ products: Array })

function deleteProduct(id) {
  if (confirm('Yakin ingin menghapus produk ini?')) {
    router.delete(`/admin/produk/${id}`)
  }
}
</script>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
export default { layout: AdminLayout }
</script>
