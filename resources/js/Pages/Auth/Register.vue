<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { MailIcon, LockIcon, UserIcon, EyeIcon, EyeOffIcon } from 'lucide-vue-next'

const showPassword = ref(false)
const showPasswordConfirm = ref(false)

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('register'), {
    onSuccess: () => {
      window.location.href = route('Login'); // Redirect ke halaman Home
    },
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}


</script>

<template>
  <GuestLayout>
    <Head title="Register" />

    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg px-8 py-6 mt-10">
      <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">Buat Akun Baru</h2>

      <form @submit.prevent="submit" class="space-y-6">

        <!-- Name -->
        <div>
          <InputLabel for="name" value="Nama Lengkap" />
          <div class="relative mt-1">
            <UserIcon class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" />
            <input
              id="name"
              type="text"
              class="pl-10 pr-4 py-2 w-full border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
            />
          </div>
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <!-- Email -->
        <div>
          <InputLabel for="email" value="Email" />
          <div class="relative mt-1">
            <MailIcon class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" />
            <input
              id="email"
              type="email"
              class="pl-10 pr-4 py-2 w-full border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              v-model="form.email"
              required
              autocomplete="email"
            />
          </div>
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <!-- Password -->
        <div>
          <InputLabel for="password" value="Password" />
          <div class="relative mt-1">
            <LockIcon class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" />
            <input
              :type="showPassword ? 'text' : 'password'"
              id="password"
              class="pl-10 pr-10 py-2 w-full border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              v-model="form.password"
              required
              autocomplete="new-password"
            />
            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-gray-500">
              <component :is="showPassword ? EyeOffIcon : EyeIcon" class="h-5 w-5" />
            </button>
          </div>
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <!-- Password Confirmation -->
        <div>
          <InputLabel for="password_confirmation" value="Konfirmasi Password" />
          <div class="relative mt-1">
            <LockIcon class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" />
            <input
              :type="showPasswordConfirm ? 'text' : 'password'"
              id="password_confirmation"
              class="pl-10 pr-10 py-2 w-full border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
            />
            <button type="button" @click="showPasswordConfirm = !showPasswordConfirm" class="absolute right-3 top-2.5 text-gray-500">
              <component :is="showPasswordConfirm ? EyeOffIcon : EyeIcon" class="h-5 w-5" />
            </button>
          </div>
          <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <!-- Button -->
        <div class="flex justify-center">
          <PrimaryButton
            class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 text-white"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Daftar
          </PrimaryButton>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm mt-4 text-gray-600">
          Sudah punya akun?
          <Link href="/login" class="text-indigo-500 hover:underline">Masuk di sini</Link>
        </p>
      </form>
    </div>
  </GuestLayout>
</template>
