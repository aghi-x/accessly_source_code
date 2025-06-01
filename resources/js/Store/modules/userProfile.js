// src/Store/modules/userProfile.js

const state = {
    first_name: '',
    last_name: '',
    profile_picture: null, // store file name or URL
  }
  
  const mutations = {
    setFirstName(state, value) {
      state.first_name = value
    },
    setLastName(state, value) {
      state.last_name = value
    },
    setProfilePicture(state, value) {
      state.profile_picture = value
    },
    setUserProfile(state, payload) {
      state.first_name = payload.first_name
      state.last_name = payload.last_name
      state.profile_picture = payload.profile_picture
    },
    clearUserProfile(state) {
      state.first_name = ''
      state.last_name = ''
      state.profile_picture = null
    },
  }
  
  const getters = {
    fullName: (state) => `${state.first_name} ${state.last_name}`,

    profilePicture: (state) => {
        if (!state.profile_picture) {
          return 'avatar.png'; // ✅ fallback image
        }
    
        return `${state.profile_picture}`;
      }


  }


  const actions = {
    initUserProfile({ commit }) {
      const firstName = localStorage.getItem('first_name')
      const lastName = localStorage.getItem('last_name')
      const profilePicture = localStorage.getItem('profile_picture')
  
      if (firstName || lastName || profilePicture) {
        commit('setUserProfile', {
          first_name: firstName,
          last_name: lastName,
          profile_picture: profilePicture,
        })
      }
    },
  }

  

  
  export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions,
  }
  