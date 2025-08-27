<template>
  <nav class="bg-gray-900 shadow-lg text-white py-2.5 px-6 flex justify-between items-center fixed top-0 w-full z-50">
    <!-- Logo -->
   <Link href="/">
  <span className="text-gray font-serif text-2xl ">
    Toko La Perabot
  </span>
</Link>



    <!-- Desktop Menu -->
    <ul class="hidden md:flex space-x-6 items-center">
      <li v-for="item in navItems" :key="item.path">
      <a
  href="javascript:void(0)"
  @click.prevent="scrollToSection(item.id)"
  :class="[
    'relative px-1 py-2 font-medium transition-all duration-300',
    'hover:text-amber-300'
  ]"
>
  {{ item.label }}
</a>

      </li>
    </ul>

    <!-- Right Side -->
    <div class="flex items-center gap-2 relative">
      <!-- Cart -->
      <div class="relative group" @mouseenter="cartHover = true" @mouseleave="cartHover = false">
        <div class="p-1.5 rounded-full hover:bg-white/10 transition duration-200 flex items-center relative">
          <i class="fas fa-shopping-cart text-lg text-white-700"></i>
          <span
            v-if="cartCount > 0"
            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
          >
            {{ cartCount > 9 ? '9+' : cartCount }}
          </span>
        </div>

        <!-- Cart Preview -->
        <div 
          v-show="cartHover"
          class="absolute right-0 top-full mt-2 w-80 bg-white text-gray-900 rounded-xl shadow-2xl z-50 p-4 border border-gray-200"
          @mouseenter="cartHover = true"
          @mouseleave="cartHover = false"
        >
          <h3 class="font-bold text-base mb-3 flex items-center gap-2">
            <i class="fas fa-shopping-bag text-amber-500"></i>
            Keranjang Belanja
          </h3>

          <div v-if="cartItems.length > 0" class="max-h-64 overflow-y-auto pr-1 custom-scrollbar">
            <div
              v-for="item in cartItems"
              :key="item.id"
              class="flex items-center py-3 border-b border-gray-100 hover:bg-gray-50 rounded-lg px-2 transition-colors"
            >
              <img :src="item.image" alt="item.name" class="w-12 h-12 object-cover rounded-lg" />
              <div class="ml-3 flex-1 min-w-0">
                <p class="text-sm font-medium truncate">{{ item.name }}</p>
                <p class="text-xs text-gray-600 mt-1">
                  {{ item.quantity }} × Rp{{ formatPrice(item.price) }}
                </p>
              </div>
              <button @click.prevent="removeFromCart(item.id)" class="text-gray-400 hover:text-red-500 ml-2">
                <i class="fas fa-times text-xs"></i>
              </button>
            </div>

            <div class="mt-4 flex justify-between items-center pt-3 border-t border-gray-100">
              <span class="font-bold">Total:</span>
              <span class="font-bold text-indigo-600">Rp{{ formatPrice(cartTotal) }}</span>
            </div>

            <Link href="/cart" class="block mt-4 text-center bg-indigo-600 text-white py-2.5 rounded-lg hover:bg-indigo-700 transition-all">
              Lihat Keranjang
            </Link>
          </div>

          <div v-else class="text-center py-6">
            <i class="fas fa-shopping-cart text-3xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">Keranjang belanja kosong</p>
            <Link href="/produk" class="inline-block mt-3 text-sm text-indigo-600 hover:text-indigo-500 hover:underline">
              Mulai Belanja
            </Link>
          </div>
        </div>
      </div>

      <!-- User Dropdown -->
      <template v-if="user">
        <div class="relative" ref="dropdownContainer">
          <button @click.stop="toggleDropdown" class="flex items-center gap-1 group focus:outline-none">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-amber-400 to-amber-600 flex items-center justify-center text-white font-medium">
              {{ userInitials }}
            </div>
            <i 
              class="fas fa-chevron-down text-xs text-gray-300 group-hover:text-white transition-transform duration-200 ml-0.5"
              :class="{'rotate-180': dropdownOpen}"
            ></i>
          </button>

          <transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <div 
              v-if="dropdownOpen" 
              ref="dropdownRef" 
              @click.stop 
              class="absolute right-0 mt-1 w-56 bg-gray-800 text-white rounded-xl shadow-2xl z-50 overflow-hidden border border-white/10"
            >
              <div class="px-4 py-3 border-b border-white/10">
                <p class="font-medium truncate">{{ user.name }}</p>
                <p class="text-xs text-gray-400 truncate">{{ user.email }}</p>
              </div>
              <Link href="/profile" class="flex items-center px-4 py-2.5 hover:bg-white/5 text-sm">
                <i class="fas fa-user-circle mr-3 text-gray-400 w-4 text-center"></i> Profil Saya
              </Link>

              <div class="border-t border-white/10"></div>
              <Link as="button" method="post" href="/logout" class="flex items-center w-full text-left px-4 py-2.5 hover:bg-white/5 text-sm text-red-400 hover:text-red-300">
                <i class="fas fa-sign-out-alt mr-3 w-4 text-center"></i> Keluar
              </Link>
            </div>
          </transition>
        </div>
      </template>

      <!-- Guest Buttons -->
      <template v-else>
        <div class="hidden md:flex items-center gap-2">
          <Link href="/login" class="px-3 py-1.5 rounded-lg hover:bg-white/10 transition-colors text-sm font-medium">
            Masuk
          </Link>
<Link
  href="/register"
  className="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg hover:shadow-lg hover:shadow-amber-500/20 transition-all text-sm font-medium"
>
  Daftar
</Link>

        </div>
      </template>

      <!-- Mobile Menu Toggle -->
      <button @click="toggleMenu" class="md:hidden text-white text-xl p-1.5 rounded-lg hover:bg-white/10 transition-colors" aria-label="Toggle menu">
        <i :class="['fas', menuOpen ? 'fa-times' : 'fa-bars']"></i>
      </button>
    </div>

    <!-- Mobile Menu -->
    <!-- Mobile Menu -->
<transition
  enter-active-class="transition duration-200 ease-out"
  enter-from-class="transform opacity-0 -translate-y-2"
  enter-to-class="transform opacity-100 translate-y-0"
  leave-active-class="transition duration-150 ease-in"
  leave-from-class="transform opacity-100 translate-y-0"
  leave-to-class="transform opacity-0 -translate-y-2"
>
  <div v-if="menuOpen" class="md:hidden absolute top-full left-0 w-full bg-gray-800 text-white py-3 px-4 shadow-2xl z-40">
    <ul class="space-y-2">
      <li v-for="item in navItems" :key="item.path">
        <a
          href="javascript:void(0)"
          @click.prevent="scrollToSection(item.id)"
          class="block py-2 px-3 rounded-lg hover:bg-white/10 transition-colors font-medium text-sm"
        >
          {{ item.label }}
        </a>
      </li>
      <li>
        <Link href="/cart" class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-white/10 text-sm" @click="closeMenu">
          <span>Keranjang</span>
          <span v-if="cartCount > 0" class="bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ cartCount }}</span>
        </Link>
      </li>
      <template v-if="user">
        <li class="border-t border-white/10 mt-2 pt-2">
          <Link as="button" method="post" href="/logout" class="block py-2 px-3 rounded-lg hover:bg-white/10 text-sm text-red-400 w-full text-left" @click="closeMenu">
            Keluar
          </Link>
        </li>
      </template>
      <template v-else>
        <li class="border-t border-white/10 mt-2 pt-2 space-y-2">
          <Link href="/login" class="block py-2 px-3 rounded-lg hover:bg-white/10 text-sm" @click="closeMenu">
            Masuk
          </Link>
          <Link href="/register" class="block py-2 px-3 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 hover:shadow-lg text-sm text-center" @click="closeMenu">
            Daftar Sekarang
          </Link>
        </li>
      </template>
    </ul>
  </div>
</transition>

  </nav>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const user = usePage().props.auth?.user

// Navigation items
const navItems = [
  { id: 'beranda', label: 'Beranda' },
  { id: 'produk', label: 'Produk' },
  { id: 'tentang', label: 'Tentang Kami' },
  { id: 'kontak', label: 'Kontak' }
]

const scrollToSection = (id) => {
  const el = document.getElementById(id)
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' })
    closeMenu()
  }
}

// Dropdown state
const dropdownOpen = ref(false)
const dropdownRef = ref(null)
const dropdownContainer = ref(null)
import { useCartStore } from '@/stores/cart'
const cart = useCartStore()
// Menu state
const menuOpen = ref(false)

// Cart hover state
const cartHover = ref(false)

// State keranjang
const cartItems = ref([])
const cartCount = computed(() => cartItems.value.reduce((total, item) => total + item.quantity, 0))
const cartTotal = computed(() => cartItems.value.reduce((total, item) => total + (item.price * item.quantity), 0))

// User initials
const userInitials = computed(() => {
  if (!user?.value) return ''
  const names = user.value.name.split(' ')
  return names.map(name => name[0].toUpperCase()).join('').substring(0, 2)
})

// Fungsi untuk memformat harga
const formatPrice = (price) => {
  return new Intl.NumberFormat('id-ID').format(price)
}

// Fungsi untuk mendapatkan URL gambar yang lebih robust
const getImageUrl = (imagePath) => {
  if (!imagePath) return '/images/placeholder-product.jpg'
  
  // Jika sudah URL lengkap
  if (imagePath.startsWith('http') || imagePath.startsWith('https') || imagePath.startsWith('//')) {
    return imagePath
  }
  
  // Jika sudah diawali dengan storage/
  if (imagePath.startsWith('storage/')) {
    return `/${imagePath}?${Date.now()}`
  }
  
  // Jika path dari Laravel storage
  return `/storage/${imagePath.replace('public/', '').replace('storage/', '')}?${Date.now()}`
}

// Fungsi untuk menangani error gambar
const handleImageError = (event, item) => {
  event.target.src = '/images/placeholder-product.jpg'
  // Update item di cartItems untuk mencegah loop error
  const index = cartItems.value.findIndex(i => i.id === item.id)
  if (index !== -1) {
    cartItems.value[index].image = '/images/placeholder-product.jpg'
  }
}

// Fungsi untuk update keranjang
const updateCart = () => {
  try {
    const savedCart = JSON.parse(localStorage.getItem('cart')) || []
    cartItems.value = savedCart.map(item => ({
      ...item,
      image: getImageUrl(item.image),
      cacheKey: Date.now() // Cache buster
    }))
    console.log('Cart updated:', cartItems.value) // Untuk debugging
  } catch (error) {
    console.error('Failed to load cart:', error)
    cartItems.value = []
  }
}

// Fungsi untuk menghapus item
const removeFromCart = (productId) => {
  try {
    const savedCart = JSON.parse(localStorage.getItem('cart')) || []
    const updatedCart = savedCart.filter(item => item.id !== productId)
    localStorage.setItem('cart', JSON.stringify(updatedCart))
    updateCart()
    window.dispatchEvent(new Event('cart-updated'))
  } catch (error) {
    console.error('Failed to remove item:', error)
  }
}

// Toggle functions
const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value
}

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value
}

const closeMenu = () => {
  menuOpen.value = false
}

// Click outside handler
const handleClickOutside = (event) => {
  if (dropdownOpen.value && dropdownContainer.value && !dropdownContainer.value.contains(event.target)) {
    dropdownOpen.value = false
  }
}

// Navigation link class
const navLinkClass = (path) => usePage().url === path ? 'text-amber-400' : ''

// Lifecycle hooks
onMounted(() => {
  updateCart()
  window.addEventListener('cart-updated', updateCart)
  document.addEventListener('click', handleClickOutside)
  
  // Tambahkan listener untuk perubahan dari tab/window lain
  window.addEventListener('storage', (event) => {
    if (event.key === 'cart') {
      updateCart()
    }
  })
})

onBeforeUnmount(() => {
  window.removeEventListener('cart-updated', updateCart)
  window.removeEventListener('storage', updateCart)
  document.removeEventListener('click', handleClickOutside)
})


</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
}

/* Animasi untuk cart dropdown */
.cart-enter-active, .cart-leave-active {
  transition: all 0.2s ease;
}
.cart-enter-from, .cart-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>