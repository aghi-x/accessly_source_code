<script setup>
import RoleForm from '../Components/RoleForm.vue';
import axios from 'axios';
import { ref, computed, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import { Link } from '@inertiajs/vue3'
import MenuButton from '@/Components/MenuButton.vue';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const action = 'add';
const loading = ref(false)
const isAdded = ref(false);
const isSubmitting = ref(false);
const errors = ref([]);

const props = defineProps({
  role: {
    type: Object,
    default: () => [],
  },
  allPermissions:
  {
    type: Array,
    default: () => [],
  } 
}
)


const addRole = async (formData) => {

  errors.value = [];
  isAdded.value = false;
  loading.value = true;

  if (isSubmitting.value) return;

  isSubmitting.value = true;

  try {
    const response = await axios.post(`/roles`, formData, {
      headers: {
        'Accept': 'application/json',
      },
    });

    // Check for validation errors
    if (response.data.success === false && response.data.errors) {
      const generatedErrors = response.data.errors;

      for (let field in generatedErrors) {
        if (generatedErrors[field][0]) {
          errors.value.push(generatedErrors[field][0]);
          console.log(`${field} error: ${generatedErrors[field][0]}`);
        }
      }

      isAdded.value = false;
      return;
    }

    // Success: role added
    isAdded.value = true;



    const role = response.data.role;

    // Wait 1 seconds before redirecting


    setTimeout(() => {
      router.visit(`/roles/${role.id}`)
    }, 1000)









  } catch (error) {
    console.error("Unexpected error:", error);
    isAdded.value = false;
    errors.value.push("An unexpected error occurred.");
  } finally {
    isSubmitting.value = false;
    loading.value = false;
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

    <Head title="Add role" />



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

<div v-if="loading" class="loading-overlay">
  <div class="loading-content">
    <p>Please wait ...</p>
    <span class="loading loading-ring loading-xl"></span>
  </div>
</div>


    <!-- Topbar with toggle button -->
    <MenuButton />



                        <!-- All Roles Button -->
                        <Link
      href="/roles"
      class="btn btn-info text-white btn-sm ml-10"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4  text-white">
          <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
        </svg>
         All Roles
    </Link>



          <div class="card bg-base-100 shadow-md p-6">
<div class="card-body">
<!-- Title -->
<div class="flex items-center justify-between mb-6">
  <h1 class="text-2xl font-bold">Add role</h1>
</div>



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
    <span>Role Added successfully.</span>
  </div>
</div>





    <RoleForm    :role="{
    name: '',
    permissions: [],
    users: []
  }" :allPermissions="allPermissions" :action="action" @submit="addRole" />







  </div>


</div>
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