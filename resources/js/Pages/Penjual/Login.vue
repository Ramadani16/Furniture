<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 font-poppins">
    <div class="flex w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden">
      
      <!-- Bagian Kiri (Form Login) -->
      <div class="w-full md:w-1/2 p-8 md:p-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
        <p class="text-gray-500 mb-8">Silakan login untuk melanjutkan ke dashboard penjual.</p>

        <form @submit.prevent="submit" class="space-y-6">
          
          <!-- Email -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
              <i class="fas fa-envelope text-blue-400 mr-2"></i>
              <input
                v-model="form.email"
                type="email"
                placeholder="Masukkan email"
                class="w-full outline-none text-gray-700"
                required
              />
            </div>
          </div>

          <!-- Password -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
              <i class="fas fa-lock text-blue-400 mr-2"></i>
              <input
                v-model="form.password"
                type="password"
                placeholder="Masukkan password"
                class="w-full outline-none text-gray-700"
                required
              />
            </div>
          </div>

          <!-- Tombol Login -->
          <button
            type="submit"
            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200 flex items-center justify-center gap-2 shadow-md"
          >
            <i class=""></i>
            Login
          </button>

          <!-- Link Registrasi -->
          <p class="text-center text-gray-600 text-sm">
            Belum punya akun?
            <a href="/penjual/register" class="text-blue-600 hover:underline font-medium">
              Registrasi di sini
            </a>
          </p>
        </form>
      </div>

      <!-- Bagian Kanan (Ilustrasi) -->
      <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-500 to-blue-700 items-center justify-center p-6">
        <div class="text-center text-white">
          <i class="fas fa-store text-6xl mb-4"></i>
          <h3 class="text-2xl font-semibold">Toko La Perabot</h3>
          <p class="text-blue-100 mt-2">Tempat terbaik untuk mengelola produk Anda.</p>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    async submit() {
      try {
        const response = await axios.post('/penjual/login', this.form);
        // Redirect jika login berhasil
        this.$inertia.visit('/penjual/dashboard');
      } catch (error) {
        // Tangani kesalahan login
        alert('Login gagal! Cek email & password.');
      }
    }
  }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

.font-poppins {
  font-family: 'Poppins', sans-serif;
}
</style>

<!-- Pastikan Font Awesome di-load di index.html atau App.vue -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
