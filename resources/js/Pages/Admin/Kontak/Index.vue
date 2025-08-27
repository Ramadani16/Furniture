<template>
  <AdminLayout>
    <div class="p-6 font-poppins">
      <h2 class="text-2xl font-semibold mb-2 tracking-wide text-gray-800">
        Pesan Masuk
      </h2>
      <p class="text-gray-600 mb-6 leading-relaxed">
        Daftar pesan yang dikirim melalui form kontak
      </p>

      <!-- Scroll Wrapper -->
      <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-100">
        <table class="min-w-full border-collapse text-gray-700 text-sm">
          <thead>
            <tr class="bg-gray-100 text-left font-medium text-gray-800 uppercase tracking-wider">
              <th class="px-4 py-3 border-b">Nama</th>
              <th class="px-4 py-3 border-b">Email</th>
              <th class="px-4 py-3 border-b">Telepon</th>
              <th class="px-4 py-3 border-b">Pesan</th>
              <th class="px-4 py-3 border-b">Tanggal</th>
              <th class="px-4 py-3 border-b">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="msg in messages.data"
              :key="msg.id"
              class="hover:bg-gray-50 transition-colors duration-150"
            >
              <td class="px-4 py-3 border-b">{{ msg.name }}</td>
              <td class="px-4 py-3 border-b">{{ msg.email }}</td>
              <td class="px-4 py-3 border-b">{{ msg.phone }}</td>
              <td class="px-4 py-3 border-b truncate max-w-xs">{{ msg.message }}</td>
              <td class="px-4 py-3 border-b">{{ msg.created_at }}</td>
              <td class="px-4 py-3 border-b whitespace-nowrap">
                <button
                  @click="openModal(msg)"
                  class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-150"
                >
                  Lihat
                </button>
                <button
                  @click="deleteMessage(msg.id)"
                  class="text-red-600 ml-3 hover:text-red-800 font-medium transition-colors duration-150"
                >
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal -->
      <div
        v-if="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <div
          class="bg-white p-6 rounded-xl shadow-lg w-full max-w-lg border border-gray-200"
        >
          <h3 class="text-lg font-semibold mb-4 tracking-wide text-gray-800">
            Detail Pesan
          </h3>
          <div class="space-y-2 text-gray-700 text-sm leading-relaxed">
            <p><strong>Nama:</strong> {{ selectedMessage.name }}</p>
            <p><strong>Email:</strong> {{ selectedMessage.email }}</p>
            <p><strong>Telepon:</strong> {{ selectedMessage.phone }}</p>
            <p><strong>Pesan:</strong></p>
            <p
              class="bg-gray-50 p-3 rounded-lg border border-gray-200 leading-relaxed"
            >
              {{ selectedMessage.message }}
            </p>
            <p class="mt-2 text-xs text-gray-500">
              <strong>Tanggal:</strong> {{ selectedMessage.created_at }}
            </p>
          </div>

          <div class="mt-6 text-right">
            <button
              @click="showModal = false"
              class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-150 text-gray-700"
            >
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { router } from "@inertiajs/vue3";

export default {
  props: {
    messages: Object,
  },
  components: {
    AdminLayout,
  },
  data() {
    return {
      showModal: false,
      selectedMessage: {},
    };
  },
  methods: {
    openModal(msg) {
      this.selectedMessage = msg;
      this.showModal = true;
    },
    deleteMessage(id) {
      if (confirm("Yakin ingin menghapus pesan ini?")) {
        router.delete(`/admin/messages/${id}`, {
          preserveScroll: true,
        });
      }
    },
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");
.font-poppins {
  font-family: "Poppins", sans-serif;
}
</style>
