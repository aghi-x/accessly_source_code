<script setup>
import LeftSidebar from '@/Components/LeftSidebar.vue';
import MenuButton from '@/Components/MenuButton.vue';
import ConfirmDialog from '@/Components/ConfirmDialog.vue';
import UsersList from '../Components/UsersList.vue'; // ✔ use .vue and fix ././

import axios from 'axios'
import { ref, computed, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const users = ref([])
const isDeleted = ref(false)
const connotBeDeleted = ref(false)
const connotBeDeletedMessage = ref('')


// Confirm dialog state
const showConfirmDialog = ref(false);
const userToDelete = ref(null);



const props = defineProps({
  users: {
    type: Object,
    required: true
  }
});


const links = computed(() => props.users.links)


const ConfirmDialogMessage = ref('')



async function deleteUser() {

  try {
    const response = await axios.delete(`/users/${userToDelete.value}`)

    // ✅ Handle access or validation denial from backend
    if (response.data.deleted !== true) {
      connotBeDeleted.value = true
      connotBeDeletedMessage.value = response.data.message || 'Action denied.'
      setTimeout(() => {
        connotBeDeleted.value = false
      }, 3000) // 3 seconds
      return;
    }

    users.value = users.value.filter(user => user.id !== userToDelete.value); 
    flashDeleteFlag() 

  } catch (error) {
    alert('Something went wrong while deleting the user.')
  }
}


function flashDeleteFlag() {
  isDeleted.value = true

  setTimeout(() => {
    isDeleted.value = false
  }, 3000) // 3 seconds
}


function requestUserDeletion(userId) {
  userToDelete.value = userId
  ConfirmDialogMessage.value = `Are you sure you want to delete this user (ID: ${userId})?`
  showConfirmDialog.value = true
}



onMounted(() => {
  users.value = props.users.data
})

</script>

<template>
    <div>

      <Head title="Users" />

      <div class="grid grid-cols-12 gap-4">

      <!-- Left column (3/12) -->
      <div  v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">
      <LeftSidebar  @close-sidebar="sidebarOpen = false"/>
      </div>

<!-- Right column (9/12) -->
<div :class="['bg-base-100 p-4 transition-all duration-300', sidebarOpen ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10' : 'col-span-12']">


        <!-- Topbar with toggle button -->
        <MenuButton />

        <ConfirmDialog
          v-model="showConfirmDialog"
          title="Delete user"
          :message="ConfirmDialogMessage"
          @confirm="deleteUser"
        />




        <!-- Add User Button -->
        <Link href="/users/add" class="btn btn-info text-white btn-sm ml-10">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>

        Add User</Link>

      <div class="card overflow-x-auto bg-base-100 shadow-md p-6">
    <div class="card-body">
      <!-- Title -->
      <div class="flex items-center justify-between mb-6">

        <div class="flex">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="size-5 text-info">        
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
        </svg>
        <p class=" ml-2 font-semibold text-gray-500">

         Users Management</p>
      </div>

        </div>





    <!-- Cannot be deleted Notification Container -->
    <div
  v-if="connotBeDeleted"
  class="fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 px-4"
>
  <div class="alert alert-error text-sm text-white shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 13l4 4L19 7" />
    </svg>
    <span>Admin cannot be deleted.</span>
  </div>
</div>










    <!-- Success Notification Container -->
    <div
  v-if="isDeleted"
  class="fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 px-4"
>
  <div class="alert alert-success text-sm text-white shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 13l4 4L19 7" />
    </svg>
    <span>User deleted successfully.</span>
  </div>
</div>




      <!-- Users List -->
      <UsersList :users="users"  :links="links"  @delete="requestUserDeletion" />

    </div>
  </div>

</div>
</div>

  </div>
</template>
