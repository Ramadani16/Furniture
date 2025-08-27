import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: JSON.parse(localStorage.getItem('cartItems') || '[]')
  }),
  getters: {
    count: (state) => state.items.reduce((s, i) => s + i.quantity, 0),
    total: (state) => state.items.reduce((s, i) => s + i.price * i.quantity, 0)
  },
  actions: {
    add(item) {
      const existing = this.items.find(p => p.id === item.id)
      if (existing) {
        existing.quantity += 1
      } else {
        this.items.push({ ...item, quantity: 1 })
      }
      this.save()
    },
    remove(id) {
      this.items = this.items.filter(i => i.id !== id)
      this.save()
    },
    clear() {
      this.items = []
      this.save()
    },
    save() {
      localStorage.setItem('cartItems', JSON.stringify(this.items))
    }
  }
})
