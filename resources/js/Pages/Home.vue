<template>
  <div>
    <Navbar />

    <!-- Hero / Beranda -->
    <section id="beranda">
      <HeroSection class="mb-16" />
    </section>

    <!-- Produk -->
    <section id="produk">
      <SectionTitle title="Daftar Produk" class="mb-6" />
      <ProductList :kategori="'furniture'" class="mb-12" />
      <ProductList :kategori="'elektronik'" class="mb-12" />
      <ProductList :kategori="'bazar'" class="mb-16" />
    </section>

    <!-- Tentang Kami -->
    <section id="tentang">
      <ServiceList class="mb-6" />
    </section>

    <!-- Kontak -->
    <section id="kontak">
      <SectionTitle title="Hubungi Kami" class="mb-6" />
      <ContactForm class="mb-6" />
    </section>

    <Footer class="mt-12" />

    <!-- Popup Daftar -->
    <RegisterPopup 
      v-if="showPopup" 
      @close="showPopup = false" 
      @login-with-google="handleGoogleLogin"
    />
  </div>
</template>


<script setup>
import Navbar from '@/Components/Navbar.vue'
import { ref, onMounted } from 'vue'
import HeroSection from '@/Components/HeroSection.vue'
import SectionTitle from '@/Components/SectionTitle.vue'
import ProductList from '@/Components/ProductList.vue'
import ServiceList from '@/Components/ServiceList.vue'
import ContactForm from '@/Components/ContactForm.vue'
import Footer from '@/Components/Footer.vue'
import { usePage } from '@inertiajs/vue3'


const showPopup = ref(false)

onMounted(() => {
  setTimeout(() => {
    showPopup.value = true
  }, 5000)
})

import axios from 'axios'

const handleGoogleLogin = async () => {
  try {
    const res = await axios.get('http://localhost:8000/api/auth/google/redirect')
    window.location.href = res.data.url
  } catch (err) {
    console.error("Gagal dapat URL Google:", err)
  }
}






</script>

