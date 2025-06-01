  
<script setup>

import SearchUsers from '../Components/SearchUsers.vue'
import SearchRoles from '../Components/SearchRoles.vue'
import SearchPermissions from '../Components/SearchPermissions.vue'
import { ref, computed } from 'vue'
import axios from 'axios'
import LeftSidebar from '@/Components/LeftSidebar.vue'
import MenuButton from '@/Components/MenuButton.vue'
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'

const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const loading = ref(false)
const query = ref('')
const results = ref(null)
let debounceTimeout = null
  
function search() {
if (!query.value) {
    results.value = null
    return
}

loading.value = true

axios.get(`/search?q=${query.value}`).then((res) => {
    results.value = res.data
    console.log(res)
})
.finally(() => {
    loading.value = false
})
}

function debouncedSearch() {
clearTimeout(debounceTimeout)
debounceTimeout = setTimeout(() => {
    search()
}, 300)
}
</script>
  



<template>
  <div class="grid grid-cols-12 gap-4">

    <Head title="Search" />
    <!-- Left Sidebar -->
    <div v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">
      <LeftSidebar @close-sidebar="store.dispatch('closeSidebar')" />
    </div>

    <!-- Main Content -->
    <div
      :class="[
        'bg-base-100 p-6 transition-all duration-300 rounded-lg shadow-lg',
        sidebarOpen
          ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10'
          : 'col-span-12'
      ]"
    >
      <MenuButton />

      <div class="p-6 max-w-4xl mx-auto space-y-6">
        <!-- Search Input -->
        <div class="relative">
          <input
            type="text"
            v-model="query"
            @input="debouncedSearch"
            placeholder="Search Users, Roles, Permissions ..."
            class="input input-bordered w-full text-sm p-3 pl-10 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
          />
          <i class="fas fa-search absolute left-4 top-3 text-gray-500"></i>
        </div>

        <!-- Loading Indicator -->
        <div v-if="loading" class="loading-overlay">
          <div class="loading-content">
            <p class="text-white">Please wait ...</p>
            <span class="loading loading-ring loading-xl text-white"></span>
          </div>
        </div>

        <!-- Results -->
        <div v-if="results" class="space-y-8">
          <SearchUsers :users="results.users" />
          <SearchRoles :roles="results.roles" />
          <SearchPermissions :permissions="results.permissions" />
        </div>

      </div>
    </div>
  </div>
</template>

<style scoped>
/* Input Styles */
.input {
  background-color: #f9fafb;
  border: 1px solid #ddd;
  border-radius: 9999px; /* Rounded input */
}

.input:focus {
  border-color: #618ef1;
  box-shadow: 0 0 0 2px rgba(38, 166, 254, 0.3);
}

/* Loading Overlay */
.loading-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 10;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 8px;
}

.loading-content {
  text-align: center;
  color: white;
  font-size: 1.2rem;
}

/* Search Results */
.space-y-8 {
  padding-top: 1.5rem;
}

.space-y-8 > * {
  padding-top: 1rem;
  padding-bottom: 1rem;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
}

.space-y-8 > *:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

i {
  font-size: 1.25rem;
}

/* MenuButton */
button {
  margin-bottom: 15px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .p-6 {
    padding: 1rem;
  }

  .max-w-4xl {
    max-width: 100%;
  }
}
</style>
