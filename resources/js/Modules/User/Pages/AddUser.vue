<script setup>
import UserForm from '../Components/UserForm.vue';
import MenuButton from '@/Components/MenuButton.vue';
import axios from 'axios';
import { ref, computed, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import { Link } from '@inertiajs/vue3'
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const loading = ref(false)
const isAdded = ref(false);
const isSubmitting = ref(false);
const generatedErrors = ref('')
const errors = ref([]);


const props = defineProps({
  user: {
    type: Object,
    default: () => ({}),
  },
  roles: {
    type: Array,
    default: () => [],
  },
})


const addUser = async (formData) => {
  isAdded.value = false;
  errors.value = [];
  loading.value = true


  if (isSubmitting.value) return;
  isSubmitting.value = true;

  try {
    const response = await axios.post(`/users`, formData, {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'multipart/form-data',
      },
    });

    // Check for validation or business logic errors
    if (response.data.success === false && response.data.errors) {
      const generatedErrors = response.data.errors;

      for (let field in generatedErrors) {
        if (generatedErrors[field][0]) {
          errors.value.push(generatedErrors[field][0]);
        }
      }

      isAdded.value = false;
      return;
    }

    // Success: user added
    isAdded.value = true;
    const user = response.data.user;

        // Wait 1 seconds before redirecting
        setTimeout(() => {
      router.visit(`/users/${user.id}`)
    }, 1000)

  } catch (error) {
    isAdded.value = false;
    errors.value.push("An unexpected error occurred.");
  } finally {
    isSubmitting.value = false;
    loading.value = false
  
  
  }
};

watchEffect(() => {
  if (errors.value.length > 0) {
    setTimeout(() => {
      errors.value = []
    }, 5000)
  }
})


</script>


<template>

<div>
  <Head title="Add user" />
<div class="grid grid-cols-12 gap-4">
<!-- Left column (3/12) -->
<div  v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">

<LeftSidebar  @close-sidebar="sidebarOpen = false"/>

</div>

<!-- Right column (9/12) -->
<div :class="['bg-base-100 p-4 transition-all duration-300', sidebarOpen ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10' : 'col-span-12']">
    <!-- Topbar with toggle button -->
    <MenuButton />

    <div v-if="loading" class="loading-overlay">
  <div class="loading-content">
    <p>Please wait ...</p>
    <span class="loading loading-ring loading-xl"></span>
  </div>
</div>

    <!-- All Users Button -->
    <Link
      href="/users"
      class="btn btn-info btn-sm ml-10 text-white"
    >
      
    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="size-4 text-white">        
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
        </svg>
        
        All Users
    </Link>

  <div>




<!-- Notification Container -->
<div
  v-if="errors.length"
  class="fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 space-y-2 px-4"
>
  <!-- Loop through error messages -->
  <div
    v-for="(error, index) in errors"
    :key="index"
    class="alert alert-error text-sm text-white shadow-lg"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856C18.403 20 19 19.403 19 18.674V5.326C19 4.597 18.403 4 17.674 4H6.326C5.597 4 5 4.597 5 5.326v13.348C5 19.403 5.597 20 6.326 20z"/>
    </svg>
    <span>{{ error }}</span>
  </div>
</div>




    <!-- Success Notification Container -->
    <div
  v-if="isAdded"
  class="fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 px-4"
>
  <div class="alert alert-success text-sm text-white shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 13l4 4L19 7" />
    </svg>
    <span>User Added successfully.</span>
  </div>
</div>



    <UserForm :user="user" :allRoles="roles" @submit-user="addUser"/>

<div v-if="isAdded">New user has been created</div>
  </div>


</div>
</div>
</div>
</template>
  

<style scoped>

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8); /* or dark: rgba(0, 0, 0, 0.5) */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999; /* Ensure it’s above other elements */
}

.loading-content {
  text-align: center;
  font-size: 1.5rem;
}

</style>