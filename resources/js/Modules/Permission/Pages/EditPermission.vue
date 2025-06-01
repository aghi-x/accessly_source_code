<script setup>
import PermissionForm from '../Components/PermissionForm.vue';
import axios from 'axios';
import { ref, computed, watchEffect } from 'vue';
import LeftSidebar from '@/Components/LeftSidebar.vue';
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import MenuButton from '@/Components/MenuButton.vue';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const action = 'edit';
const isUpdated = ref(false);
const isSubmitting = ref(false);
const errors = ref([]);

const props = defineProps({
    permission: {
    type: Object,
  },

  users: {
    type: Object,
  }
}
)

const updatePermission = async (formData) => {
  errors.value = []
  isUpdated.value = false

  if (isSubmitting.value) return
  isSubmitting.value = true

  try {
    const response = await axios.put(`/permissions/${props.permission.id}`, formData, {
      headers: {
        'Accept': 'application/json',
      },
    })

    // ✅ Handle validation error
    if (response.data.status === 'validation_failed') {
      const generatedErrors = response.data.errors
      for (let field in generatedErrors) {
        errors.value.push(generatedErrors[field][0])
      }
      return
    }

    // ✅ Success
    isUpdated.value = true
        // Wait 1 seconds before redirecting
        setTimeout(() => {
      router.visit(`/permissions/${props.permission.id}`)
    }, 1000)

  } catch (error) {
    console.error(error)
    errors.value.push('Unexpected error occurred.')
  } finally {
    isSubmitting.value = false
  }
}



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
  <Head title="Edit permissions" />


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

    <!-- All Permissions Button -->
    <Link
      href="/permissions"
      class="btn btn-info text-white btn-sm ml-10"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4  text-white">
          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
        </svg>
     All Permission
    </Link>

        <!-- Permission Info Button -->
        <Link
    :href="`/permissions/${permission.id}`"
      class="btn btn-info text-white btn-sm ml-10"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6  text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
          </svg>

 Permission Info
    </Link>

    <div class="card bg-base-100 shadow-md p-6">
    <div class="card-body">
    <!-- Title -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Edit Permission</h1>
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
  v-if="isUpdated"
  class="fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 px-4"
>
  <div class="alert alert-success text-sm text-white shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 13l4 4L19 7" />
    </svg>
    <span>Permission updated successfully.</span>
  </div>
</div>



    <PermissionForm :permission="permission"   :users="users" :action="action"  @submit="updatePermission"/>


  </div></div>
</div>


</div>

</div>
</div>



































</template>
  