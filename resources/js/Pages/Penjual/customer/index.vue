<template>
  <PenjualLayout title="Data Customer">
    <div class="p-6 bg-white rounded shadow">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Customer</h2>
        <button
          @click="showCreateModal = true"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          <i class="fa fa-plus mr-2"></i> Tambah Customer
        </button>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
          <thead class="bg-gray-100 text-left text-sm font-medium text-gray-600">
            <tr>
              <th class="px-4 py-3">Nama</th>
              <th class="px-4 py-3">Email</th>
              <th class="px-4 py-3">Terdaftar</th>
              <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
            <tr v-for="user in customers" :key="user.id" class="hover:bg-gray-50">
              <td class="px-4 py-3">{{ user.name }}</td>
              <td class="px-4 py-3">{{ user.email }}</td>
              <td class="px-4 py-3">{{ new Date(user.created_at).toLocaleDateString() }}</td>
              <td class="px-4 py-3 text-center">
                <div class="flex justify-center space-x-3">
                  <button
                    @click="openEditModal(user)"
                    class="text-blue-600 hover:underline flex items-center"
                  >
                    <i class="fas fa-pen-to-square mr-1"></i> Edit
                  </button>
                  <button
                    @click="confirmDelete(user.id)"
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

    <!-- MODAL TAMBAH CUSTOMER -->
    <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h3 class="text-xl font-semibold mb-4">Tambah Customer</h3>
        <form @submit.prevent="submitCreate">
          <div class="mb-3">
            <label class="block text-sm">Nama</label>
            <input v-model="createForm.name" type="text" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">Email</label>
            <input v-model="createForm.email" type="email" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-3">
            <label class="block text-sm">Password</label>
            <input v-model="createForm.password" type="password" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="flex justify-end space-x-2">
            <button type="button" @click="showCreateModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <!-- MODAL EDIT CUSTOMER -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h3 class="text-xl font-semibold mb-4">Edit Customer</h3>
        <form @submit.prevent="submitEdit">
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
          <div class="flex justify-end space-x-2">
            <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
          </div>
        </form>
      </div>
    </div>
  </PenjualLayout>
</template>

<script setup>
import PenjualLayout from '@/Layouts/PenjualLayout.vue'
import { usePage, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const { props } = usePage()
const customers = props.customers

// CREATE
const showCreateModal = ref(false)
const createForm = ref({
  name: '',
  email: '',
  password: '',
})

const submitCreate = () => {
  router.post(route('penjual.customer.store'), createForm.value, {
    onSuccess: () => {
      showCreateModal.value = false
      createForm.value = { name: '', email: '', password: '' }
    },
  })
}

// EDIT
const showEditModal = ref(false)
const editForm = ref({
  id: null,
  name: '',
  email: '',
  password: '',
})

const openEditModal = (user) => {
  showEditModal.value = true
  editForm.value = {
    id: user.id,
    name: user.name,
    email: user.email,
    password: '',
  }
}

const submitEdit = () => {
  router.put(route('penjual.customer.update', editForm.value.id), editForm.value, {
    onSuccess: () => {
      showEditModal.value = false
    },
  })
}

// DELETE
const confirmDelete = (id) => {
  if (confirm('Yakin ingin menghapus customer ini?')) {
    router.delete(route('penjual.customer.destroy', id), {
      preserveScroll: true,
    })
  }
}
</script>
