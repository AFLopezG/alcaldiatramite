import { defineStore } from 'pinia'

export const globalStore = defineStore('global', {
  state: () => ({
    counter: 0,
    user: {},
    unit: {},
    cargo: {},
    isLoggedIn: !!localStorage.getItem('tokenTerri'),

    booluser: false,
    boolregistro: false,
    boolasignacion: false,
    boolseg: false,
    booldelete: false,
    boolanual: false,
    }),
  getters: {
    doubleCount: (state) => state.counter * 2
  },
  actions: {
    increment () {
      this.counter++
    }
  }
})
