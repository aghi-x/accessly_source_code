
<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import axios from 'axios'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import MenuButton from '@/Components/MenuButton.vue';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)

const props = defineProps({
  user: Object,
  permissions: Array
})

const roleNames = props.user.roles.map(role => role.name).join(', ')
const rolesArray = ref(roleNames.split(','));
const permissionNames = props.permissions

const form = ref({
current_password: '',
new_password: '',
new_password_confirmation: ''
})

const errors = ref({})
const success = ref('')

const unauthorized = ref('')



const submit = async () => {
try {
  const response = await axios.post('/profile/change-password', form.value)

  if (response.data.status === true) {
    success.value = response.data.message
    errors.value = {}
    form.value = {
      current_password: '',
      new_password: '',
      new_password_confirmation: ''
    }
  } else {
    errors.value = {
      current_password: response.data.message
    }
    success.value = ''
  }

} catch (error) {
if (error.response) {
  const status = error.response.status

  if (status === 403) {
    unauthorized.value = error.response.data.message
    success.value = ''
    errors.value = {}
    console.log("Access Denied")
  } else if (status === 422) {
    errors.value = error.response.data.errors
    success.value = ''
    unauthorized.value = ''
    console.log("Validation Error")
  } else {
    success.value = ''
    unauthorized.value = ''
    console.error("Unexpected Error (Other Status)", error)
  }

} else {
  console.error("Unexpected Error (No Response)", error)
}
}

}

</script>





<template>
  <div>

    <Head title="Profile" />



    <div class="grid grid-cols-12 gap-4">

      <!-- Left column (3/12) - Profile Image -->
      <div v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">
        <LeftSidebar @close-sidebar="sidebarOpen = false" />
      </div>

      <!-- Right column (9/12) - User Information -->
      <div :class="[
        'bg-base-100 p-4 transition-all duration-300',
        sidebarOpen ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10' : 'col-span-12'
      ]">
        <!-- Topbar with toggle button -->
        <MenuButton />

        <!-- Edit Info Button -->
        <Link :href="`/users/${user.id}/edit`" class="btn btn-info text-white btn-sm ml-10">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M17 3l4 4-10 10H7V14L17 3z" />
    </svg>
     Edit Info
        </Link>

        <div class="p-4 max-w-xl mx-auto">


          <div class="flex items-center space-x-6 mb-6">
            <!-- Profile Picture -->
            <div v-if="user.profile_picture" class="flex flex-col items-center">
              <img :src="`${user.profile_picture}`" alt="Profile" class="w-32 h-32 rounded-full border-2 border-gray-300" />
            </div>

            <!-- User Info -->
            <div class="space-y-2 text-gray-600 text-sm">
              <div class="flex items-center">
              </div>
              <div class="flex items-center">
                <i class="fas fa-user mr-2 text-gray-500"></i>
                <span><strong>First Name:</strong> {{ user.first_name }}</span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-user mr-2 text-gray-500"></i>
                <span><strong>Last Name:</strong> {{ user.last_name }}</span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-envelope mr-2 text-gray-500"></i>
                <span><strong>Email:</strong> {{ user.email }}</span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-cogs mr-2 text-gray-500"></i>
                <div>
    <!-- Roles Section -->
    <strong>Roles:</strong>
    <div class="flex flex-wrap gap-2 mt-2">
      <!-- Split roleNames string into an array and iterate over it -->
      <span
        v-for="(role, index) in rolesArray"
        :key="index"
        class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm"
      >
        {{ role.trim() }}  <!-- Trim any extra spaces -->
        <span v-if="index < rolesArray.length - 1"></span>
      </span>
    </div>
  </div>              </div>
              <!-- <div class="flex items-center">
                <i class="fas fa-key mr-2 text-gray-500"></i>
                <span><strong>Permissions:</strong></span>
                <div v-for="permission in permissionNames" :key="permission.id" class="ml-6">
                  <span>{{ permission }}</span>
                </div>
              </div> -->
            </div>
          </div>

          <hr class="my-6" />

          <!-- Change Password Section -->
          <div class="max-w-md mx-auto mt-10">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Change Password</h2>

            <!-- Password Change Form -->
            <form @submit.prevent="submit">
              <div class="mb-4">
                <label for="current_password" class="block text-gray-700">Current Password</label>
                <input v-model="form.current_password" id="current_password" type="password" class="input" />
                <div v-if="errors.current_password" class="text-red-500 text-sm mt-1">{{ errors.current_password }}</div>
              </div>

              <div class="mb-4">
                <label for="new_password" class="block text-gray-700">New Password</label>
                <input v-model="form.new_password" id="new_password" type="password" class="input" />
              </div>

              <div class="mb-4">
                <label for="new_password_confirmation" class="block text-gray-700">Confirm New Password</label>
                <input v-model="form.new_password_confirmation" id="new_password_confirmation" type="password" class="input" />
                <div v-if="errors.new_password" class="text-red-500 text-sm mt-1">{{ errors.new_password }}</div>
              </div>

              <button type="submit" class="btn btn-info text-white w-full mt-4">Update Password</button>
            </form>

            <!-- Success and Unauthorized Messages -->
            <div v-if="success" class="text-green-600 mt-4">{{ success }}</div>
            <div v-if="unauthorized" class="text-red-600 mt-4">{{ unauthorized }}</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<style scoped>
.input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: #f9fafb;
  color: #4b5563;
  font-size: 1rem;
  transition: all 0.2s ease;
}

.input:focus {
  border-color: #2563eb;
  outline: none;
  background-color: white;
}



/* Icons styling */
i {
  font-size: 1.2rem;
}
</style>
