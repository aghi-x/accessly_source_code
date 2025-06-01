<script setup>
import PermissionsList from '../Components/PermissionsList.vue'; // ✔ use .vue and fix ././
import ConfirmDialog from '@/Components/ConfirmDialog.vue';
import axios from 'axios'
import { computed, ref, onMounted } from 'vue'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import { Link } from '@inertiajs/vue3'
import MenuButton from '@/Components/MenuButton.vue';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const links = computed(() => props.permissions.links)
const permissions = ref([])
const isDeleted = ref(false)
const showConfirmDialog = ref(false);
const permissionToDelete = ref(null);
const ConfirmDialogMessage = ref('')


const props = defineProps({
    permissions: {
    type: Object,
    required: true
  }
});


async function deletePermission() {
  try {
    await axios.delete(`/permissions/${permissionToDelete.value}`)
    permissions.value = permissions.value.filter(permission => permission.id !== permissionToDelete.value)
    flashDeleteFlag()
  } catch (error) {
    alert('Something went wrong while deleting the permission.')
  }
}


function flashDeleteFlag() {
  isDeleted.value = true

  setTimeout(() => {
    isDeleted.value = false
  }, 3000) // 3 seconds
}



function requestUserDeletion(permissionId) {
  permissionToDelete.value = permissionId
  ConfirmDialogMessage.value = `Are you sure you want to delete this permission  (ID: ${permissionId})?`
  showConfirmDialog.value = true
}



onMounted(() => {
  permissions.value = props.permissions.data
})

</script>

<template>
<div>
  <Head title="Permissions" />


<div class="grid grid-cols-12 gap-4">

<!-- Left column (3/12) -->
<div  v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">

<LeftSidebar  @close-sidebar="sidebarOpen = false"/>


</div>


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


    <ConfirmDialog
          v-model="showConfirmDialog"
          title="Delete permission"
          :message="ConfirmDialogMessage"
          @confirm="deletePermission"
        />




    <!-- Add Permission Button -->
    <Link
      href="/permissions/add"
      class="btn btn-info text-white btn-sm ml-10"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>


      Add Permission
    </Link>

    <div class="card bg-base-100 shadow-md p-6">
    <div class="card-body">
    <!-- Title -->
    <div class="flex items-center justify-between mb-6">        
      
<div class="flex">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4  text-info">
          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
        </svg>
<p class=" ml-2 font-semibold text-gray-500">

   Permissions Management</p>
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
    <span>Permission deleted successfully.</span>
  </div>
</div>


    <PermissionsList
      :permissions="permissions"
      :links="links"
      @delete="requestUserDeletion"


    />

</div>
</div>


</div>

</div>
</div>




</template>
