<script setup>
import UsersForm from '../Components/UserForm.vue';
import MenuButton from '@/Components/MenuButton.vue';
import axios from 'axios';
import { ref, computed, watchEffect } from 'vue';
import LeftSidebar from '@/Components/LeftSidebar.vue';
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { onMounted } from 'vue';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'

const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const isUpdated = ref(false);
const isSubmitting = ref(false);
const isAdmin = ref(false)
const loading = ref(false)
const errors = ref([]);


const props = defineProps({
  user: {
    type: Object,
  },
  allRoles: Array,
  permissions: Array,
}
)

onMounted(() => {
    if (props.user?.roles?.some(role => role.name === 'admin')) {
        isAdmin.value = true
    }
})






const updateUser = async (formData) => {
  errors.value = [];
  isUpdated.value = false;
  loading.value = true

  if (isSubmitting.value) return;

  isSubmitting.value = true;

  try {
    const response = await axios.post(`/users/${props.user.id}`, formData, {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'multipart/form-data',
      },
    });

    // If response indicates failure via success: false
    if (response.data.success === false && response.data.errors) {
      isUpdated.value = false;
      const generatedErrors = response.data.errors;

      for (let field in generatedErrors) {
        if (generatedErrors[field][0]) {
          errors.value.push(generatedErrors[field][0]);
        }
      }
      return; // exit early
    }

    // Success
    isUpdated.value = true;

    if (response.data.isOwner) {


      store.commit('userProfile/setUserProfile', {
      first_name: response.data.user.first_name,
      last_name: response.data.user.last_name,
      profile_picture: response.data.user.profile_picture, // should be a path or filename
    })
    // Save to localStorage too
    localStorage.setItem('first_name', response.data.user.first_name)
    localStorage.setItem('last_name', response.data.user.last_name)
    localStorage.setItem('profile_picture', response.data.user.profile_picture)
  }

    // Wait 1 seconds before redirecting
    setTimeout(() => {
      router.visit(`/users/${props.user.id}`)
    }, 1000)

    
  } catch (error) {
    isUpdated.value = false;
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

  <Head title="Edit user" />

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

    <!-- Add User Button -->
    <Link
      href="/users/add"
      class="btn btn-info btn-sm ml-10 text-white"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>

       Add User
    </Link>


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


        <!-- User Info Button -->
        <Link
    :href="`/users/${user.id}`"
      class="btn btn-info btn-sm ml-10 text-white"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
            </svg>
            
     User Info
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
  v-if="isUpdated"
  class="fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 px-4"
>
  <div class="alert alert-success text-sm text-white shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 13l4 4L19 7" />
    </svg>
    <span>User updated successfully.</span>
  </div>
</div>


  <UsersForm   :user="user"  :allRoles="allRoles" :permissions="permissions" :isAdmin="isAdmin"  @submit-user="updateUser"/>
  

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