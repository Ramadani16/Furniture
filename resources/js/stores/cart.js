// resources/js/stores/cart.js
import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => ({
    cartItems: JSON.parse(localStorage.getItem('cartItems')) || [],
  }),

  getters: {
    cartTotal: (state) => {
      return state.cartItems.reduce((total, item) => total + item.price * item.quantity, 0)
    },
    itemCount: (state) => {
      return state.cartItems.reduce((count, item) => count + item.quantity, 0)
    },
  },

  actions: {
    addToCart(product) {
      const existing = this.cartItems.find(p => p.id === product.id)
      if (existing) {
        existing.quantity++
      } else {
        this.cartItems.push({ ...product, quantity: 1 })
      }
      this.saveCart()
    },

    removeFromCart(productId) {
      this.cartItems = this.cartItems.filter(item => item.id !== productId)
      this.saveCart()
    },

    updateQuantity(productId, qty) {
      const item = this.cartItems.find(item => item.id === productId)
      if (item && qty > 0) {
        item.quantity = qty
        this.saveCart()
      }
    },

    clearCart() {
      this.cartItems = []
      this.saveCart()
    },

    saveCart() {
      localStorage.setItem('cartItems', JSON.stringify(this.cartItems))
    }
  }
})
