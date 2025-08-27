<template>
  <div class="container mx-auto px-4 md:px-6 lg:px-8">
    <!-- Category Title & Selengkapnya Button -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800 capitalize">{{ categoryLabel }}</h2>
      <button 
  v-if="!isLoading && products.length > 0"
  @click="goToCategory"
>
  Selengkapnya
</button>

    </div>
    
    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <div
        v-for="product in products"
        :key="product.id"
        class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 overflow-hidden"
      >
        <div class="relative overflow-hidden h-48">
          <img
            :src="getImageUrl(product.image)"
            :alt="product.name"
            class="w-full h-full object-cover rounded-t-2xl group-hover:scale-105 transition-transform duration-500"
            @error="handleImageError"
          />
          <button
            @click.stop="viewProduct(product)"
            class="absolute bottom-3 right-3 bg-white/90 text-indigo-600 p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-indigo-600 hover:text-white"
            aria-label="Quick view"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>

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
          
          <div class="flex items-center mt-1">
            <span class="text-xs px-2 py-1 rounded-full" :class="categoryColorClasses[product.category]">
              {{ categoryLabels[product.category] }}
            </span>
          </div>

          <p class="text-sm text-gray-500 line-clamp-2 mt-2 min-h-[40px]">
            {{ product.description || 'Tidak ada deskripsi' }}
          </p>

          <div class="mt-3 flex items-center justify-between">
            <p class="text-indigo-600 font-bold text-base">
              Rp {{ formatPrice(product.price) }}
              <span v-if="product.discount_price" class="text-xs text-gray-400 line-through ml-1">
                Rp {{ formatPrice(product.discount_price) }}
              </span>
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

    <!-- Loading & Empty States -->
    <div v-if="isLoading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
      <div v-for="i in 4" :key="i" class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="h-48 w-full bg-gray-200 animate-pulse"></div>
        <div class="p-4 space-y-2">
          <div class="h-4 bg-gray-200 animate-pulse rounded w-3/4"></div>
          <div class="h-4 bg-gray-200 animate-pulse rounded w-full"></div>
          <div class="h-4 bg-gray-200 animate-pulse rounded w-1/2"></div>
        </div>
      </div>
    </div>

    <div v-if="!isLoading && products.length === 0" class="text-center py-12">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <p class="text-gray-500 mt-3">Tidak ada produk dalam kategori ini</p>
      <button 
        @click="fetchProducts"
        class="mt-4 px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition flex items-center mx-auto"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        Muat Ulang
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import axios from 'axios'

const props = defineProps({ 
  kategori: {
    type: String,
    required: true,
    validator: value => ['furniture', 'elektronik', 'bazar'].includes(value)
  },
  initialProducts: {
    type: Array,
    default: () => []
  }
})

const products = ref(props.initialProducts)
const isLoading = ref(false)
const isLoadingMore = ref(false)
const page = ref(1)
const lastPage = ref(1)
const wishlist = ref([])

const categoryLabels = {
  furniture: 'Furniture',
  elektronik: 'Elektronik',
  bazar: 'Bazar'
}

const categoryColorClasses = {
  furniture: 'bg-amber-100 text-amber-800',
  elektronik: 'bg-blue-100 text-blue-800',
  bazar: 'bg-purple-100 text-purple-800'
}

const categoryLabel = computed(() => categoryLabels[props.kategori] || props.kategori)

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

const fetchProducts = async (loadMore = false) => {
  if (loadMore && page.value >= lastPage.value) return

  try {
    loadMore ? isLoadingMore.value = true : isLoading.value = true

    const response = await axios.get('/produk/get-by-category', {
      params: {
        category: props.kategori,
        page: loadMore ? page.value + 1 : 1
      }
    })

    const data = response.data

    products.value = loadMore
      ? [...products.value, ...data.data]
      : data.data

    page.value = data.current_page
    lastPage.value = data.last_page
  } catch (error) {
    console.error('Gagal memuat produk:', error)
  } finally {
    isLoading.value = false
    isLoadingMore.value = false
  }
}

const loadMore = async () => {
  if (isLoadingMore.value || page.value >= lastPage.value) return;
  
  try {
    isLoadingMore.value = true;
    const response = await axios.get('/produk/get-by-category', {
      params: {
        category: props.kategori,
        page: page.value + 1
      }
    });

    const data = response.data;
    products.value = [...products.value, ...data.data];
    page.value = data.current_page;
    lastPage.value = data.last_page;
  } catch (error) {
    console.error('Gagal memuat lebih banyak produk:', error);
  } finally {
    isLoadingMore.value = false;
  }
};

const viewProduct = (product) => {
  // Navigasi ke halaman detail produk
  window.location.href = `/produk/${product.id}`
}
const goToCategory = () => {
  window.location.href = route('produk.index', { kategori: props.kategori })
}


const toggleWishlist = (product) => {
  const index = wishlist.value.findIndex(item => item.id === product.id)
  if (index === -1) {
    wishlist.value.push(product)
  } else {
    wishlist.value.splice(index, 1)
  }
  // Simpan wishlist ke localStorage
  localStorage.setItem('wishlist', JSON.stringify(wishlist.value))
}

const isInWishlist = (productId) => {
  return wishlist.value.some(item => item.id === productId)
}

const addToCart = (product) => {
  try {
    // 1. Ambil data keranjang yang ada dari localStorage
    let cart = []
    const cartData = localStorage.getItem('cart')
    if (cartData) {
      cart = JSON.parse(cartData)
    }

    // 2. Cek apakah produk sudah ada di keranjang
    const existingItem = cart.find(item => item.id === product.id)

    if (existingItem) {
      // Jika ada, tambah quantity (jika stok mencukupi)
      if (product.stock && existingItem.quantity >= product.stock) {
        alert('Stok produk tidak mencukupi')
        return
      }
      existingItem.quantity += 1
    } else {
      // Jika belum ada, tambahkan produk baru
      cart.push({
        id: product.id,
        name: product.name,
        price: product.price,
        image: product.image,
        quantity: 1,
        max_stock: product.stock || null // Simpan info stok maksimal
      })
    }

    // 3. Simpan kembali ke localStorage
    localStorage.setItem('cart', JSON.stringify(cart))

    // 4. Trigger event untuk navbar
    window.dispatchEvent(new CustomEvent('cart-updated'))

    // 5. Notifikasi ke user
    alert(`${product.name} telah ditambahkan ke keranjang`)
  } catch (error) {
    console.error('Gagal menambahkan ke keranjang:', error)
    alert('Terjadi kesalahan saat menambahkan ke keranjang')
  }
}

// Load wishlist dari localStorage saat komponen dimount
onMounted(() => {
  if (props.initialProducts.length === 0) {
    fetchProducts()
  }

  // Load wishlist dari localStorage
  const savedWishlist = localStorage.getItem('wishlist')
  if (savedWishlist) {
    wishlist.value = JSON.parse(savedWishlist)
  }
})
</script>