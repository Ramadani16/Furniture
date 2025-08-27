<template>
  <footer class="bg-gray-900 text-white pt-12 pb-6">
    <div class="container mx-auto px-4">
      <!-- Main Footer Content -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
        <!-- Store Info -->
        <div class="space-y-4">
          <div class="flex items-center">
            <i class=" text-2xl text-indigo-500 mr-2"></i>
            <span class="text-xl font-bold">Toko La Perabot</span>
          </div>
          <p class="text-gray-400">
            Menyediakan furniture berkualitas dengan desain modern untuk rumah dan kantor Anda.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-whatsapp"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-tiktok"></i>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Tautan </h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition">Beranda</a></li>
            <li><a href="#produk" class="text-gray-400 hover:text-white transition">Produk</a></li>
            <li><a href="#tentang" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
            <li><a href="#kontak" class="text-gray-400 hover:text-white transition">Kontak</a></li>
          </ul>
        </div>

        <!-- Categories -->
        <div>
          <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Kategori</h3>
          <ul class="space-y-2">
            <li><a href="#produk" class="text-gray-400 hover:text-white transition">Furniture</a></li>
            <li><a href="#produk" class="text-gray-400 hover:text-white transition">Elektronik</a></li>
            <li><a href="#produk" class="text-gray-400 hover:text-white transition">Bazar</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Kontak Kami</h3>
          <ul class="space-y-3">
            <li class="flex items-start">
              <i class="fas fa-map-marker-alt text-indigo-500 mt-1 mr-3"></i>
              <span class="text-gray-400">Jl. Furniture No. 123, Jakarta</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-phone-alt text-indigo-500 mt-1 mr-3"></i>
              <span class="text-gray-400">+62 123 4567 8910</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-envelope text-indigo-500 mt-1 mr-3"></i>
              <span class="text-gray-400">info@furniturestore.com</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-clock text-indigo-500 mt-1 mr-3"></i>
              <span class="text-gray-400">Buka: Senin-Minggu (09.00-17.00)</span>
            </li>
          </ul>
        </div>
      </div>

      

      <!-- Copyright -->
      <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-500 text-sm mb-4 md:mb-0">
          &copy; {{ new Date().getFullYear() }} Toko La Perabot. All Rights Reserved.
        </p>
        <div class="flex space-x-6">
          <a href="#" class="text-gray-500 hover:text-white text-sm transition">Syarat & Ketentuan</a>
          <a href="#" class="text-gray-500 hover:text-white text-sm transition">Kebijakan Privasi</a>
          <a href="#" class="text-gray-500 hover:text-white text-sm transition">FAQ</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
// No script needed for basic footer
</script>

<style scoped>
/* Smooth transitions for hover effects */
a, button {
  transition: all 0.3s ease;
}
</style>