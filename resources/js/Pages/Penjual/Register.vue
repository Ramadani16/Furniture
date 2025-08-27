<template>
  <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Registrasi Penjual</h2>
    <form @submit.prevent="submit" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
      
      <!-- Kolom Kiri -->
      <div class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
          <input
            type="text"
            id="name"
            v-model="form.name"
            required
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
          />
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            required
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
          />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            type="password"
            id="password"
            v-model="form.password"
            required
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
          />
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
          <input
            type="password"
            id="password_confirmation"
            v-model="form.password_confirmation"
            required
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
          />
        </div>
      </div>

      <!-- Kolom Kanan -->
      <div class="space-y-4">
        <div>
          <label for="photo" class="block text-sm font-medium text-gray-700">Foto Penjual</label>
          <input
            type="file"
            id="photo"
            @change="handleFileUpload('photo', $event)"
            class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                   file:rounded file:border-0
                   file:text-sm file:font-semibold
                   file:bg-blue-50 file:text-blue-700
                   hover:file:bg-blue-100"
          />
        </div>

        <div>
          <label for="ktp" class="block text-sm font-medium text-gray-700">Nomor KTP</label>
          <input
            type="text"
            id="ktp"
            v-model="form.ktp"
            required
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
          />
        </div>

        <div>
          <label for="npwp" class="block text-sm font-medium text-gray-700">Nomor NPWP</label>
          <input
            type="text"
            id="npwp"
            v-model="form.npwp"
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
          />
        </div>

        <div class="flex items-end">
          <button
            type="submit"
            class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-colors"
          >
            Daftar
          </button>
          
        </div>
        <p class="text-center text-gray-600 text-sm">
            Sudah punya akun?
            <a href="/penjual/login" class="text-blue-600 hover:underline font-medium">
              Login di sini
            </a>
          </p>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        photo: null,
        ktp: '',
        npwp: '',
      }
    };
  },
  methods: {
    handleFileUpload(field, event) {
      this.form[field] = event.target.files[0];
    },
    async submit() {
      const formData = new FormData();
      for (const key in this.form) {
        formData.append(key, this.form[key]);
      }

      try {
        const response = await axios.post('/penjual/register', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        alert('Registrasi berhasil!');
        this.$inertia.visit('/penjual/dashboard');
      } catch (error) {
        if (error.response && error.response.status === 422) {
          alert('Validasi gagal: ' + JSON.stringify(error.response.data.errors));
        } else {
          alert('Terjadi kesalahan.');
        }
      }
    }
  }
};
</script>
