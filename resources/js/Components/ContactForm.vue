<template>
  <div class="container mx-auto px-4 md:px-6 lg:px-8 py-10">
    <!-- Contact Form Card -->
    <div class="bg-white shadow-lg rounded-xl p-10">
      <form @submit.prevent="handleSubmit" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Nama -->
          <div class="relative">
            <input
              v-model="form.name"
              type="text"
              id="name"
              class="peer w-full px-4 pt-5 pb-2 text-sm text-gray-900 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="Nama Lengkap"
              required
            />
            <label
              for="name"
              class="absolute left-4 top-2.5 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-sm peer-focus:text-indigo-600"
            >
              Nama Lengkap
            </label>
          </div>

          <!-- Email -->
          <div class="relative">
            <input
              v-model="form.email"
              type="email"
              id="email"
              class="peer w-full px-4 pt-5 pb-2 text-sm text-gray-900 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="Email"
              required
            />
            <label
              for="email"
              class="absolute left-4 top-2.5 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-sm peer-focus:text-indigo-600"
            >
              Email
            </label>
          </div>
        </div>

        <!-- Nomor Telepon -->
        <div class="relative">
          <input
            v-model="form.phone"
            type="tel"
            id="phone"
            class="peer w-full px-4 pt-5 pb-2 text-sm text-gray-900 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="Nomor Telepon"
            required
          />
          <label
            for="phone"
            class="absolute left-4 top-2.5 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-sm peer-focus:text-indigo-600"
          >
            Nomor Telepon
          </label>
        </div>

        <!-- Pesan -->
        <div class="relative">
          <textarea
            v-model="form.message"
            id="message"
            rows="5"
            class="peer w-full px-4 pt-5 pb-2 text-sm text-gray-900 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="Pesan Anda"
            required
          ></textarea>
          <label
            for="message"
            class="absolute left-4 top-2.5 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-sm peer-focus:text-indigo-600"
          >
            Pesan Anda
          </label>
        </div>

        <!-- Tombol Submit -->
        <div>
          <button
            type="submit"
            class="w-full md:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2"
            :disabled="loading"
          >
            <i class="fas fa-paper-plane"></i>
            {{ loading ? 'Mengirim...' : 'Kirim Pesan' }}
          </button>
        </div>
      </form>
    </div>

    <!-- Popup Register -->
    <RegisterPopup v-if="showRegister" @close="showRegister = false" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'
import RegisterPopup from '@/Components/RegisterPopup.vue' // sesuaikan path

// Ambil data user dari Inertia
const page = usePage()
const isLoggedIn = ref(!!page.props.auth?.user)

const form = ref({
  name: '',
  email: '',
  phone: '',
  message: ''
})

const loading = ref(false)
const showRegister = ref(false)

const handleSubmit = () => {
  if (!isLoggedIn.value) {
    showRegister.value = true
    return
  }
  submitForm()
}

const submitForm = async () => {
  loading.value = true
  try {
    await axios.post('/kontak', form.value)
    alert('Terima kasih! Pesan Anda telah terkirim.')
    form.value = { name: '', email: '', phone: '', message: '' }
  } catch (error) {
    console.error(error)
    alert('Gagal mengirim pesan. Silakan coba lagi.')
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.peer:focus ~ label,
.peer:not(:placeholder-shown) ~ label {
  top: 0.625rem;
  left: 1rem;
  font-size: 0.75rem;
  color: #6366f1;
}
</style>
