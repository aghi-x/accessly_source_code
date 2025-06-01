<script setup>
import RolesList from '../Components/RolesList.vue'; // ✔ use .vue and fix ././
import ConfirmDialog from '@/Components/ConfirmDialog.vue';

import axios from 'axios'
import { ref, computed, onMounted } from 'vue'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import MenuButton from '@/Components/MenuButton.vue';
import { Link } from '@inertiajs/vue3'
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const roles = ref([])
const isDeleted = ref(false)
const showConfirmDialog = ref(false);
const roleToDelete = ref(null);
const ConfirmDialogMessage = ref('')
const connotBeDeleted = ref(false)
const connotBeDeletedMessage = ref('')




const props = defineProps({
  roles: {
    type: Object,
    required: true
  }
});

const links = computed(() => props.roles.links)



async function deleteRole() {

  try {
    const response = await axios.delete(`/roles/${roleToDelete.value}`);

    if (response.data.deleted !== true) {

      connotBeDeleted.value = true
      connotBeDeletedMessage.value = response.data.message || 'Cannot delete this role.'
      setTimeout(() => {
        connotBeDeleted.value = false
      }, 3000) // 3 seconds
      return;
    }
    roles.value = roles.value.filter(role => role.id !== roleToDelete.value);
    flashDeleteFlag()

  } catch (error) {
    console.error('Failed to delete role:', error);
    alert('Something went wrong while deleting the role.');
  }
}




function flashDeleteFlag() {
  isDeleted.value = true

  setTimeout(() => {
    isDeleted.value = false
  }, 3000) // 3 seconds
}


function requestUserDeletion(roleId) {
  roleToDelete.value = roleId
  ConfirmDialogMessage.value = `Are you sure you want to delete this role (ID: ${roleId})?`
  showConfirmDialog.value = true
}




onMounted(() => {
  roles.value = props.roles.data
})
</script>

<template>
    <div>

      <Head title="Roles" />

      <div class="grid grid-cols-12 gap-4">

<!-- Left column (3/12) -->
<div  v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">

<LeftSidebar  @close-sidebar="sidebarOpen = false"/>

</div>

<ConfirmDialog
          v-model="showConfirmDialog"
          title="Delete role"
          :message="ConfirmDialogMessage"
          @confirm="deleteRole"
        />


<!-- Right column (9/12) -->
<div
:class="[
'bg-base-100 p-4 transition-all duration-300',
sidebarOpen
  ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10'
  : 'col-span-12'
]"
>

    <!-- Topbar with toggle button -->
    <MenuButton />


    <!-- Add Role Button -->
    <Link
      href="/roles/add"
      class="btn btn-info btn-sm ml-10 text-white"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>

        Add Role
    </Link>

    <div class="card bg-base-100 shadow-md p-6">
    <div class="card-body">
      <!-- Title -->
      <div class="flex items-center justify-between mb-6">

      <div class="flex">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4  text-info">
          <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
        </svg>
      <p class=" ml-2 font-semibold text-gray-500">

      Roles</p>
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
    <span>Role 'admin' cannot be deleted.</span>
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
    <span>Role deleted successfully.</span>
  </div>
</div>



      <!-- Roles List -->
      <RolesList
        :roles="roles"
        :links="links"
        @delete="requestUserDeletion"
      />
    </div>
  </div>


</div>

</div>
  </div>
</template>
