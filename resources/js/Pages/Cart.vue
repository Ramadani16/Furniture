<template>
  <div class="container mx-auto py-6 px-4 max-w-6xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Keranjang Belanja</h1>

    <div v-if="cartItems.length > 0" class="grid md:grid-cols-3 gap-6">
      <!-- List Produk -->
      <div class="md:col-span-2 space-y-4">
        <div
          v-for="item in cartItems"
          :key="item.id"
          class="flex gap-4 p-4 border border-gray-100 rounded-lg shadow bg-white hover:shadow-md transition"
        >
          <!-- Gambar Produk -->
          <div class="relative">
            <img
              :src="getImageUrl(item.image)"
              :alt="'Foto ' + item.name"
              class="w-24 h-24 object-cover rounded-md border"
              @error="handleImageError"
            />
            <div v-if="item.stock < 5" class="absolute top-0 left-0 bg-red-500 text-white text-xs px-2 py-1 rounded-br-md">
              Stok: {{ item.stock }}
            </div>
          </div>

          <!-- Info Produk -->
          <div class="flex-1 flex flex-col justify-between">
            <div class="flex justify-between items-start">
              <div>
                <h3 class="font-semibold text-gray-800">{{ item.name }}</h3>
                <p class="text-xs text-gray-500 mt-1">Varian: {{ item.variant || '-' }}</p>
              </div>
              <button @click="removeFromCart(item.id)" class="text-gray-400 hover:text-red-500">
                <i class="fas fa-times"></i>
              </button>
            </div>

            <div class="flex justify-between items-center mt-4">
              <div class="flex items-center border rounded overflow-hidden">
                <button
                  @click="decreaseQuantity(item.id)"
                  class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 disabled:opacity-40"
                  :disabled="item.quantity <= 1"
                >
                  <i class="fas fa-minus text-xs"></i>
                </button>
                <span class="px-3 text-sm">{{ item.quantity }}</span>
                <button
                  @click="increaseQuantity(item.id)"
                  class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100"
                >
                  <i class="fas fa-plus text-xs"></i>
                </button>
              </div>
              <div class="text-right">
                <p class="text-base font-semibold text-indigo-600">
                  Rp {{ formatPrice(item.price * item.quantity) }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Ringkasan & Checkout -->
      <div class="bg-white p-5 rounded-lg shadow space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tambah Catatan</label>
          <textarea
            v-model="orderNotes"
            class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
            placeholder="Tulis pesan (opsional)"
            rows="3"
          ></textarea>
        </div>

        <div class="border-t pt-4 space-y-2 text-sm text-gray-700">
          <div class="flex justify-between">
            <span>Subtotal ({{ cartCount }} item)</span>
            <span class="font-medium">Rp {{ formatPrice(cartSubtotal) }}</span>
          </div>
          <div class="border-t border-gray-200 my-2"></div>
          <div class="flex justify-between font-bold text-gray-800 text-base">
            <span>Total Pembayaran</span>
            <span>Rp {{ formatPrice(cartTotal) }}</span>
          </div>
        </div>

        <button
          @click="checkoutViaWhatsApp"
          class="w-full bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg font-medium flex items-center justify-center gap-2"
        >
          <i class="fab fa-whatsapp"></i>
          Checkout Sekarang -
        </button>
      </div>
    </div>

    <!-- Jika Keranjang Kosong -->
    <div v-else class="text-center py-20">
      <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-shopping-cart text-gray-400"></i>
      </div>
      <h3 class="text-gray-600 mb-2">Keranjang kosong</h3>
      <Link href="/produk" class="inline-block text-sm text-indigo-600 hover:text-indigo-800 font-medium">
        Mulai belanja →
      </Link>
    </div>

    <!-- Popup Register -->
    <RegisterPopup v-if="showRegisterPopup" @close="showRegisterPopup = false" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import RegisterPopup from '@/Components/RegisterPopup.vue'

const page = usePage()
const isLoggedIn = computed(() => !!page.props.auth.user)
const showRegisterPopup = ref(false)

const orderNotes = ref('')
const cartItems = ref([])

const cartCount = computed(() =>
  cartItems.value.reduce((total, item) => total + item.quantity, 0)
)
const cartSubtotal = computed(() =>
  cartItems.value.reduce((total, item) => total + item.price * item.quantity, 0)
)
const cartTotal = computed(() => cartSubtotal.value)

const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price)
const getImageUrl = (path) => {
  if (!path) return '/images/default-product.png'
  if (path.startsWith('http')) return path
  return path.startsWith('storage/') ? `/${path}` : `/storage/${path.replace('public/', '')}`
}
const handleImageError = (e) => {
  e.target.src = '/images/default-product.png'
}

const updateCart = () => {
  try {
    const stored = JSON.parse(localStorage.getItem('cart')) || []
    cartItems.value = stored.map(item => ({
      ...item,
      price: Number(item.price) || 0,
      quantity: Number(item.quantity) || 1,
      stock: item.stock || 10,
      originalPrice: Number(item.originalPrice) || null
    }))
  } catch (err) {
    console.error('Gagal memuat keranjang:', err)
    cartItems.value = []
  }
}

const changeQuantity = (id, qty) => {
  if (qty < 1) return
  const updated = cartItems.value.map(i => i.id === id ? { ...i, quantity: qty } : i)
  localStorage.setItem('cart', JSON.stringify(updated))
  updateCart()
}
const increaseQuantity = (id) => {
  const item = cartItems.value.find(i => i.id === id)
  if (item) changeQuantity(id, item.quantity + 1)
}
const decreaseQuantity = (id) => {
  const item = cartItems.value.find(i => i.id === id)
  if (item) changeQuantity(id, item.quantity - 1)
}
const removeFromCart = (id) => {
  const updated = cartItems.value.filter(i => i.id !== id)
  localStorage.setItem('cart', JSON.stringify(updated))
  updateCart()
}

const checkoutViaWhatsApp = () => {
  if (!isLoggedIn.value) {
    showRegisterPopup.value = true
    return
  }

  const itemLines = cartItems.value.map(i =>
    `- ${i.name} (${i.quantity} x Rp${formatPrice(i.price)})${i.variant ? ` - ${i.variant}` : ''}`
  ).join('\n')

  const message = `Halo, saya ingin memesan:\n\n${itemLines}\n\n` +
    `*Rincian Pembayaran:*\nSubtotal: Rp${formatPrice(cartSubtotal.value)}\nTotal: Rp${formatPrice(cartTotal.value)}\n` +
    (orderNotes.value ? `\n*Catatan:* ${orderNotes.value}\n` : '') +
    `\nApakah pesanan ini bisa diproses?`

  const waNumber = '6287788283841'
  window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`, '_blank')
}

onMounted(() => {
  updateCart()
  window.addEventListener('cart-updated', updateCart)
})
</script>

<style scoped>
button, input, textarea {
  transition: all 0.15s ease;
}
button:hover {
  transform: translateY(-1px);
}
textarea {
  min-height: 80px;
  resize: none;
}
img {
  transition: transform 0.2s ease;
  background-color: #f9fafb;
}
img:hover {
  transform: scale(1.03);
}
.relative div {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
button[disabled] {
  cursor: not-allowed;
}
</style>