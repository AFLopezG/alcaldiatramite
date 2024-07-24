import { defineStore } from 'pinia'

export const globalStore = defineStore('global', {
  state: () => ({
    counter: 0,
    user: {},
    units: '',
    cargo: {},
    profiles: [],
    isLoggedIn: !!localStorage.getItem('tokenTerri'),

    booluser: false,
    boolregistro: false,
    boolasignacion: false,
    boolseg: false,
    booldelete: false,
    boolreporte: false,
    boolcambio: false,
    }),
  getters: {
    doubleCount: (state) => state.counter * 2
  },
  actions: {
    increment () {
      this.counter++
    }
  },
  
})