<script setup>
import { ref, onMounted } from 'vue'
import Navbar from '@/Components/Navbar.vue'
import { computed } from 'vue'

const filteredProducts = computed(() => {
  const keyword = searchQuery.value.toLowerCase()

  return props.products.data.filter(product => {
    const matchName = product.name.toLowerCase().includes(keyword)
    const matchKategori = props.kategori ? product.category === props.kategori : true
    return matchName && matchKategori
  })
})


const props = defineProps({
  kategori: String,
  products: Object
})

const wishlist = ref([])
const searchQuery = ref('')
const showRandomProducts = ref(false)
const randomProducts = ref([])

// Fungsi gambar
const getImageUrl = (imagePath) => {
  if (!imagePath) return '/images/placeholder-product.jpg'
  return imagePath.startsWith('http') ? imagePath : `/storage/${imagePath}`
}

const handleImageError = (event) => {
  event.target.src = '/images/placeholder-product.jpg'
}

const formatPrice = (price) => {
  return new Intl.NumberFormat('id-ID').format(price)
}

// View produk detail
const viewProduct = (product) => {
  window.location.href = `/produk/${product.id}`
}

// Wishlist
const toggleWishlist = (product) => {
  const index = wishlist.value.findIndex(item => item.id === product.id)
  if (index === -1) {
    wishlist.value.push(product)
  } else {
    wishlist.value.splice(index, 1)
  }
  localStorage.setItem('wishlist', JSON.stringify(wishlist.value))
}

const isInWishlist = (productId) => {
  return wishlist.value.some(item => item.id === productId)
}

// Keranjang
const addToCart = (product) => {
  try {
    let cart = []
    const cartData = localStorage.getItem('cart')
    if (cartData) cart = JSON.parse(cartData)

    const existingItem = cart.find(item => item.id === product.id)

    if (existingItem) {
      if (product.stock && existingItem.quantity >= product.stock) {
        alert('Stok produk tidak mencukupi')
        return
      }
      existingItem.quantity += 1
    } else {
      cart.push({
        id: product.id,
        name: product.name,
        price: product.price,
        image: product.image,
        quantity: 1,
        max_stock: product.stock || null
      })
    }

    localStorage.setItem('cart', JSON.stringify(cart))
    window.dispatchEvent(new CustomEvent('cart-updated'))
    alert(`${product.name} telah ditambahkan ke keranjang`)
  } catch (error) {
    console.error('Gagal menambahkan ke keranjang:', error)
    alert('Terjadi kesalahan saat menambahkan ke keranjang')
  }
}

// Fungsi pencarian acak
const getRandomProducts = () => {
  if (props.products.data.length > 0) {
    const shuffled = [...props.products.data].sort(() => 0.5 - Math.random())
    randomProducts.value = shuffled.slice(0, 4) // Ambil 4 produk acak
    showRandomProducts.value = true
  }
}

// Reset pencarian acak
const resetRandomSearch = () => {
  showRandomProducts.value = false
  searchQuery.value = ''
}

// Load wishlist saat halaman dimuat
onMounted(() => {
  const savedWishlist = localStorage.getItem('wishlist')
  if (savedWishlist) {
    wishlist.value = JSON.parse(savedWishlist)
  }
})
</script>

<template>
  <div>
    <!-- Navbar -->
    <Navbar />

    <div class="container mx-auto px-4 md:px-6 lg:px-8 mt-20">
      <!-- Header dengan pencarian -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2 relative inline-block">
            <span class="relative z-10">{{ kategori || 'Semua Produk' }}</span>
            <span class="absolute bottom-0 left-0 w-full h-2 bg-indigo-100 opacity-70 z-0"></span>
          </h1>
          <p class="text-gray-600">Temukan produk terbaik untuk kebutuhan Anda</p>
        </div>
        
        <div class="flex gap-2 w-full md:w-auto">
          <div class="relative flex-1 md:w-64">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari produk..."
              class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            />
            <button
              class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </div>
          <button
            @click="getRandomProducts"
            class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors flex items-center gap-2 whitespace-nowrap"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span class="hidden md:inline">Acak Produk</span>
          </button>
        </div>
      </div>

      <!-- Hasil pencarian acak -->
      <div v-if="showRandomProducts" class="mb-8">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-gray-800">Produk Pilihan Untuk Anda</h2>
          <button
            @click="resetRandomSearch"
            class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-1"
          >
            <span>Tutup</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          <div
            v-for="product in randomProducts"
            :key="product.id"
            class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden"
          >
            <div class="relative overflow-hidden h-40">
              <img
                :src="getImageUrl(product.image)"
                :alt="product.name"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                @error="handleImageError"
              />
            </div>
            <div class="p-4">
              <h3 class="font-medium text-gray-800 truncate">{{ product.name }}</h3>
              <p class="text-indigo-600 font-bold text-sm mt-2">
                Rp {{ formatPrice(product.price) }}
              </p>
              <button
                @click="viewProduct(product)"
                class="mt-3 w-full text-sm py-1.5 px-3 bg-white border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors"
              >
                Lihat Detail
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Grid Produk Utama -->
      <div
v-if="filteredProducts.length > 0"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
      >
        <div
v-for="product in filteredProducts"
          :key="product.id"
          class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border border-gray-100 overflow-hidden"
        >
          <!-- Gambar + View Button -->
          <div class="relative overflow-hidden h-48">
            <img
              :src="getImageUrl(product.image)"
              :alt="product.name"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              @error="handleImageError"
            />
            <button
              @click.stop="viewProduct(product)"
              class="absolute bottom-3 right-3 bg-white/90 text-indigo-600 p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-indigo-600 hover:text-white"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>

          <!-- Detail Produk -->
          <div class="p-4">
            <div class="flex justify-between items-start">
              <h3 class="text-lg font-semibold text-gray-800 truncate">{{ product.name }}</h3>
              <button
                @click.stop="toggleWishlist(product)"
                class="text-gray-400 hover:text-red-500 transition-colors"
                :class="{ 'text-red-500': isInWishlist(product.id) }"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </button>
            </div>

            <p class="text-sm text-gray-500 line-clamp-2 mt-2 min-h-[40px]">
              {{ product.description || 'Tidak ada deskripsi' }}
            </p>

            <div class="mt-3 flex items-center justify-between">
              <p class="text-indigo-600 font-bold text-base">
                Rp {{ formatPrice(product.price) }}
              </p>
              <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                Stok: {{ product.stock || 0 }}
              </span>
            </div>

            <!-- Tambah ke Keranjang -->
            <button
              @click.stop="addToCart(product)"
              class="mt-3 w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              Tambah ke Keranjang
            </button>
          </div>
        </div>
      </div>

      <!-- Jika kosong -->
      <div v-else class="text-center py-12">
        <div class="max-w-md mx-auto">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Produk tidak ditemukan</h3>
          <p class="mt-2 text-gray-600">Coba gunakan kata kunci lain atau lihat rekomendasi produk kami.</p>
          <button
            @click="getRandomProducts"
            class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
          >
            Lihat Produk Acak
          </button>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="products.links" class="mt-8 flex justify-center">
        <div class="flex gap-1">
          <a
            v-for="link in products.links"
            :key="link.label"
            v-html="link.label"
            :href="link.url ? link.url + '&kategori=' + kategori : '#'"
            class="px-4 py-2 rounded-md text-sm font-medium"
            :class="{
              'bg-indigo-600 text-white': link.active,
              'text-gray-700 hover:bg-gray-100': !link.active && link.url,
              'text-gray-400 cursor-not-allowed': !link.url
            }"
          />
        </div>
      </div>
    </div>
  </div>
</template>