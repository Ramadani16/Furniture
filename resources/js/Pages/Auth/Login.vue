<script setup>
import { ref } from 'vue'
import Checkbox from '@/Components/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { EyeIcon, EyeOffIcon, MailIcon, LockIcon } from 'lucide-vue-next'

defineProps({
    canResetPassword: Boolean,
    status: String,
})

const showPassword = ref(false)

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Login" />

        <div class="max-w-md mx-auto bg-white shadow-lg rounded-xl px-8 py-8 mt-12">
            <h2 class="text-2xl font-bold text-center text-indigo-600 mb-6">
                Login
            </h2>

            <div v-if="status" class="mb-4 text-sm text-green-600 font-medium text-center">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- Email -->
                <div>
                    <InputLabel for="email" value="Email" />
                    <div class="relative mt-1">
                        <MailIcon class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" />
                        <input
                            id="email"
                            type="email"
                            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
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
                            class="pl-10 pr-10 py-2 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700"
                        >
                            <component :is="showPassword ? EyeOffIcon : EyeIcon" class="h-5 w-5" />
                        </button>
                    </div>
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Remember Me & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2">Ingat saya</span>
                    </label>

                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-indigo-500 hover:underline"
                    >
                        Lupa password?
                    </Link>
                </div>

                <!-- Submit -->
                <div class="flex justify-center">
                    <PrimaryButton
                        class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 text-white"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Masuk
                    </PrimaryButton>
                </div>

                <!-- Register -->
                <p class="text-center text-sm mt-4 text-gray-600">
                    Belum punya akun?
                    <Link href="/register" class="text-indigo-500 hover:underline">Daftar</Link>
                </p>
            </form>
        </div>
    </GuestLayout>
</template>
