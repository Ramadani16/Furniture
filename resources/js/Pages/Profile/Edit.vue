<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <!-- Header -->
        <template #header>
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 rounded-xl shadow-lg">
                <h2 class="font-poppins font-semibold text-3xl text-white tracking-wide">
                    Profil Pengguna
                </h2>
                <p class="text-indigo-100 text-sm mt-1">
                    Kelola informasi pribadi, kata sandi, dan keamanan akun Anda di sini.
                </p>
            </div>
        </template>

        <!-- Main Content -->
        <div class="py-12 font-poppins">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <!-- Informasi Profil -->
                <section class="card-section">
                    <h3 class="section-title">Informasi Profil</h3>
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </section>

                <!-- Ubah Kata Sandi -->
                <section class="card-section">
                    <h3 class="section-title">Ubah Kata Sandi</h3>
                    <UpdatePasswordForm class="max-w-xl" />
                </section>

                <!-- Hapus Akun -->
                <section class="card-section">
                    <h3 class="section-title text-red-600">Hapus Akun</h3>
                    <DeleteUserForm class="max-w-xl" />
                </section>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

.font-poppins {
    font-family: 'Poppins', sans-serif;
}

.card-section {
    @apply p-6 bg-white shadow-lg hover:shadow-xl transition-all duration-300 sm:rounded-2xl border border-gray-100;
}

.section-title {
    @apply text-lg font-semibold mb-4 text-gray-800;
}
</style>
