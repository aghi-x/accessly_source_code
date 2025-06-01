<script setup>
import { useStore } from 'vuex'
import { onMounted, onUnmounted  } from 'vue'

const store = useStore()

function toggleSidebar() {
  store.dispatch('toggleSidebar')
}

const checkScreen = () => {
  if (window.innerWidth >= 768) {
    store.dispatch('openSidebar')  
  } else {
    store.dispatch('closeSidebar')
  }
}
onMounted(() => {
  checkScreen(); // check when the page loads
  window.addEventListener('resize', checkScreen); // listen to screen resizing
});

onUnmounted(() => {
  window.removeEventListener('resize', checkScreen); // clean up
});


</script>

<template>
  <button
    @click="toggleSidebar"
    class="btn btn-outline btn-info"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 stroke-current text-info" fill="none" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
    <span class="text-sm font-medium">Menu</span>
  </button>
</template>
