<template>
  <section class="bg-gray-50 py-10 lg:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-12">
      <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-12">
        Layanan Kami
      </h2>

      <!-- Grid Layanan -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-10">
        <div 
          v-for="service in services" 
          :key="service.id"
          class="group bg-white p-6 lg:p-8 rounded-2xl shadow-md hover:shadow-xl transition duration-300 border border-gray-100 hover:border-indigo-500 h-full"
        >
          <div class="flex items-center gap-4 mb-4">
            <div
              class="w-14 h-14 lg:w-16 lg:h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl lg:text-3xl transition-all group-hover:bg-indigo-600 group-hover:text-white"
            >
              <i :class="service.icon"></i>
            </div>
            <h3
              class="text-lg md:text-xl lg:text-2xl font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors"
            >
              {{ service.title }}
            </h3>
          </div>
          <p class="text-gray-600 leading-relaxed text-base lg:text-lg">
            {{ service.description }}
          </p>
        </div>
      </div>

      <!-- Gambar Cara Memesan Full Width -->
<div class="w-full mt-12">
  <img 
    src="/images/pesanan.png" 
    alt="Cara Memesan" 
    class="w-full rounded-lg shadow-md object-cover"
  >
</div>

    </div>
  </section>
</template>

<script setup>
const services = [
  {
    id: 1,
    icon: 'fas fa-pencil-ruler',
    title: 'Desain Custom',
    description: 'Buat furniture impian Anda sesuai dengan selera dan kebutuhan ruang.'
  },
  {
    id: 2,
    icon: 'fas fa-tools',
    title: 'Instalasi Profesional',
    description: 'Tim kami siap membantu pemasangan dan perakitan furniture secara rapi.'
  },
  {
    id: 3,
    icon: 'fas fa-truck-fast',
    title: 'Gratis Pengiriman',
    description: 'Nikmati layanan antar gratis khusus wilayah Jabodetabek.'
  }
]
</script>
