<template>
  <AdminLayout title="Data Penjual">
    <div class="p-6 bg-white rounded shadow">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Penjual</h2>
        <button
          @click="showCreateModal = true"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          <i class="fa fa-plus mr-2"></i> Tambah Penjual
        </button>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
          <thead class="bg-gray-100 text-left text-sm font-medium text-gray-600">
            <tr>
              <th class="px-4 py-3">Nama</th>
              <th class="px-4 py-3">Email</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3">Foto</th>
              <th class="px-4 py-3">KTP</th>
              <th class="px-4 py-3">NPWP</th>
              <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
            <tr v-for="penjual in penjuals" :key="penjual.id" class="hover:bg-gray-50">
              <td class="px-4 py-3">{{ penjual.name }}</td>
              <td class="px-4 py-3">{{ penjual.email }}</td>
              <td class="px-4 py-3">
                <span
                  :class="penjual.is_online ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                  class="px-2 py-1 rounded text-xs font-medium"
                >
                  {{ penjual.is_online ? 'Online' : 'Offline' }}
                </span>
              </td>
              <td class="px-4 py-3">
                <img
                  v-if="penjual.photo"
                  :src="`/storage/${penjual.photo}`"
                  alt="Foto"
                  class="w-10 h-10 rounded object-cover"
                />
                <span v-else class="text-gray-400">-</span>
              </td>
              <td class="px-4 py-3">
                <span v-if="penjual.ktp" class="text-gray-800">
                  {{ penjual.ktp }}
                </span>
                <span v-else class="text-gray-400">-</span>
              </td>
              <td class="px-4 py-3">
                <span v-if="penjual.npwp" class="text-gray-800">
                  {{ penjual.npwp }}
                </span>
                <span v-else class="text-gray-400">-</span>
              </td>
              <td class="px-4 py-3 text-center">
                <div class="flex justify-center space-x-3">
                  <button
                    @click="openEditModal(penjual)"
                    class="text-blue-600 hover:underline flex items-center"
                  >
                    <i class="fas fa-pen-to-square mr-1"></i> Edit
                  </button>
                  <button
                    @click="confirmDelete(penjual.id)"
                    class="text-red-600 hover:underline flex items-center"
                  >
                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- MODAL CREATE -->
    <!-- MODAL CREATE -->
<div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
    <h3 class="text-xl font-semibold mb-4">Tambah Penjual</h3>
    <form @submit.prevent="submitCreate">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <!-- Kolom Kiri -->
        <div>
          <div class="mb-3">
            <label class="block text-sm">Nama</label>
            <input v-model="createForm.name" type="text" class="w-full border rounded px-3 py-2" required />
          </div>
          <div class="mb-3">
            <label class="block text-sm">Email</label>
            <input v-model="createForm.email" type="email" class="w-full border rounded px-3 py-2" required />
          </div>
          <div class="mb-3">
            <label class="block text-sm">Password</label>
            <input v-model="createForm.password" type="password" class="w-full border rounded px-3 py-2" required />
          </div>
        </div>

        <!-- Kolom Kanan -->
        <div>
          
          <div class="mb-3">
            <label class="block text-sm">Foto</label>
            <input type="file" @change="e => createForm.photo = e.target.files[0]" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">KTP</label>
            <input v-model="createForm.ktp" type="text" class="w-full border rounded px-3 py-2" placeholder="Nomor KTP" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">NPWP</label>
            <input v-model="createForm.npwp" type="text" class="w-full border rounded px-3 py-2" placeholder="Nomor NPWP" />
          </div>
        </div>

      </div>

      <!-- Tombol -->
      <div class="flex justify-end space-x-2 mt-4">
        <button type="button" @click="showCreateModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT -->
<div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
    <h3 class="text-xl font-semibold mb-4">Edit Penjual</h3>
    <form @submit.prevent="submitEdit">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Kolom Kiri -->
        <div>
          <div class="mb-3">
            <label class="block text-sm">Nama</label>
            <input v-model="editForm.name" type="text" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">Email</label>
            <input v-model="editForm.email" type="email" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">Password (opsional)</label>
            <input v-model="editForm.password" type="password" class="w-full border rounded px-3 py-2" />
          </div>
        </div>

        <!-- Kolom Kanan -->
        <div>
          
          <div class="mb-3">
            <label class="block text-sm">Foto</label>
            <input type="file" @change="e => editForm.photo = e.target.files[0]" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">KTP</label>
            <input v-model="editForm.ktp" type="text" class="w-full border rounded px-3 py-2" placeholder="Nomor KTP" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">NPWP</label>
            <input v-model="editForm.npwp" type="text" class="w-full border rounded px-3 py-2" placeholder="Nomor NPWP" />
          </div>
        </div>

      </div>

      <!-- Tombol -->
      <div class="flex justify-end space-x-2 mt-4">
        <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
      </div>
    </form>
  </div>
</div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { usePage, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const { props } = usePage()
const penjuals = props.penjuals

// CREATE
const showCreateModal = ref(false)
const createForm = ref({
  name: '',
  email: '',
  password: '',
  is_online: 0,
  photo: null,
  ktp: null,
  npwp: null,
})

const submitCreate = () => {
  router.post(route('admin.penjual.store'), createForm.value, {
    onSuccess: () => {
      showCreateModal.value = false
      createForm.value = { name: '', email: '', password: '', is_online: 0, photo: null, ktp: null, npwp: null }
    },
    forceFormData: true,
  })
}

// EDIT
const showEditModal = ref(false)
const editForm = ref({
  id: null,
  name: '',
  email: '',
  password: '',
  is_online: 0,
  photo: null,
  ktp: null,
  npwp: null,
})
const currentEdit = ref({ ktp: null, npwp: null })

const openEditModal = (penjual) => {
  showEditModal.value = true
  currentEdit.value = { ktp: penjual.ktp, npwp: penjual.npwp }
  editForm.value = {
    id: penjual.id,
    name: penjual.name,
    email: penjual.email,
    password: '',
    is_online: penjual.is_online,
    photo: null,
    ktp: null,
    npwp: null,
  }
}

const submitEdit = () => {
  router.post(route('admin.penjual.update', editForm.value.id), {
    _method: 'PUT',
    ...editForm.value
  }, {
    onSuccess: () => {
      showEditModal.value = false
    },
    forceFormData: true,
  })
}

// DELETE
const confirmDelete = (id) => {
  if (confirm('Yakin ingin menghapus penjual ini?')) {
    router.delete(route('admin.penjual.destroy', id), {
      preserveScroll: true,
    })
  }
}
</script>
