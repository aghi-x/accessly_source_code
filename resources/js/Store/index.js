import { createStore } from 'vuex'
import userProfile from './modules/userProfile'

export default createStore({
  modules: {
    userProfile,
    // other modules...
  },
  
  state: {
    sidebarOpen: true
  },
  mutations: {
    TOGGLE_SIDEBAR(state) {
      state.sidebarOpen = !state.sidebarOpen
    },
    OPEN_SIDEBAR(state) {
      state.sidebarOpen = true
    },
    CLOSE_SIDEBAR(state) {
      state.sidebarOpen = false
    }
  },
  actions: {
    toggleSidebar({ commit }) {
      commit('TOGGLE_SIDEBAR')
    },
    openSidebar({ commit }) {
      commit('OPEN_SIDEBAR')
    },
    closeSidebar({ commit }) {
      commit('CLOSE_SIDEBAR')
    }
  }
})
