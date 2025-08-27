<template>
  <section
    class="relative w-full h-[500px] sm:h-[600px] lg:h-[700px] pt-[88px] flex items-center justify-center text-white overflow-hidden"
  >
    <!-- Slider Gambar Background -->
    <div class="absolute inset-0 w-full h-full z-0">
      <div class="relative w-full h-full">
        <!-- Gambar 1 -->
        <img
          src="/images/hero.png"
          alt="Furniture 1"
          class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-1000 opacity-100"
          :class="{ 'opacity-0': currentSlide !== 0 }"
        />
        <!-- Gambar 2 -->
        <img
          src="/images/hero2.jpg"
          alt="Furniture 2"
          class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-1000 opacity-0"
          :class="{ 'opacity-100': currentSlide === 1 }"
        />
        <!-- Gambar 3 -->
        <img
          src="/images/hero3.jpg"
          alt="Furniture 3"
          class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-1000 opacity-0"
          :class="{ 'opacity-100': currentSlide === 2 }"
        />
      </div>
    </div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/20 z-10"></div>

    <!-- Konten -->
    <div class="relative z-20 container mx-auto px-4 md:px-6 lg:px-8 text-center animate-fade-in">
      <h1 class="text-3xl sm:text-5xl font-bold mb-4 drop-shadow-lg">
        Selamat Datang di Toko La Perabot
      </h1>
      <p class="text-lg sm:text-xl mb-6 drop-shadow-md">
        Temukan produk & jasa terbaik untuk kebutuhan rumah Anda <br>
      " Pasti Jual, Pasti Beli, Pasti Cair"
      </br>
      </p>
      
      <a
        href="#produk"
        class="inline-block bg-indigo-600 hover:bg-indigo-700 transition-colors px-6 py-3 rounded-full font-semibold shadow-lg"
      >
        Lihat Produk
      </a>
    </div>
  </section>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue';

export default {
  setup() {
    const currentSlide = ref(0);
    const totalSlides = 3; // Sesuaikan dengan jumlah gambar
    let interval;

    const nextSlide = () => {
      currentSlide.value = (currentSlide.value + 1) % totalSlides;
    };

    onMounted(() => {
      interval = setInterval(nextSlide, 3000); // Ganti slide setiap 3 detik
    });

    onBeforeUnmount(() => {
      clearInterval(interval);
    });

    return {
      currentSlide
    };
  }
};
</script>

<style scoped>
/* Pastikan gambar selalu memenuhi container tanpa terpotong */
img {
  object-position: center center;
  min-width: 100%;
  min-height: 100%;
}

/* Untuk mobile, kita bisa menyesuaikan object-position jika perlu */
@media (max-width: 640px) {
  img {
    object-position: center 25%; /* Sesuaikan posisi vertikal untuk mobile */
  }
}
</style>