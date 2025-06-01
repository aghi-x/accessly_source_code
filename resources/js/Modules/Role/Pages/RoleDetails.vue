<script setup>
import { ref, computed } from 'vue'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import { Link } from '@inertiajs/vue3'
import MenuButton from '@/Components/MenuButton.vue';
import { useStore } from 'vuex'
import { router } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'


function goToDetails(userId) {
  router.visit(`/users/${userId}`)
}

const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)

const props = defineProps({
  role: Object
})

// Pagination logic
const currentPage = ref(1)
const perPage = 4

const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * perPage
  return props.role.users.slice(start, start + perPage)
})

const totalPages = computed(() => Math.ceil(props.role.users.length / perPage))

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++
}

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--
}


function resolveImage(path) {
  if (!path || path === 'null') return '/uploads/profile_pictures/avatar.jpg';

  if (path.includes('/storage/')) {
    path = path.replace('/storage/', '/uploads/');
  }

  if (path.startsWith('http') || path.startsWith('/uploads')) {
    return path;
  }

  return `/${path.replace(/^\/+/, '')}`;
}

</script>


<template>

<div>

  <Head title="Role details" />

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

              <!-- Add Role Button -->
    <Link
      href="/roles/add"
      class="btn btn-info text-white btn-sm ml-10"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
     Add Role
    </Link>


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



        <!-- Edit Role Info Button -->
        <Link
    :href="`/roles/${role.id}/edit`"
      class="btn btn-info text-white btn-sm ml-10"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M17 3l4 4-10 10H7V14L17 3z" />
    </svg>
     Edit Role Info
    </Link>




          <div class="card bg-base-100 shadow-md p-6">
    <div class="card-body space-y-6">

      <!-- Title -->
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold"> Role Details</h1>
      </div>

      <!-- Role Name -->
      <div>
        <h2 class="text-lg font-semibold text-info">Name</h2>
        <p class="text-base-content">{{ role.name }}</p>
      </div>

      <!-- Divider -->
      <div class="divider"> Permissions</div>

      <!-- Permissions -->

      <div v-if="role.permissions.length > 0" class="space-y-2">
    <!-- Display permissions as words separated by commas -->
    <div class="flex flex-wrap gap-2">
      <span
        v-for="(perm, index) in role.permissions"
        :key="perm.id"
        class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"
      >
        {{ perm.name }}<span v-if="index < role.permissions.length - 1"></span>
      </span>
    </div>
  </div>


      <div v-else class="text-gray-400 italic">
        No permissions assigned to this role.
      </div>

      <!-- Divider -->
      <div class="divider"> Users with this Role</div>

<!-- Users -->
<div v-if="role.users && role.users.length > 0" class="space-y-4">



  <!-- User List Section -->
  <ul class="list bg-base-100 rounded-box shadow-md">
    <!-- Section Title -->
    <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Users</li>

    <!-- User List -->
    <li
      v-for="(user, index) in paginatedUsers"
      :key="user.id"
      class="list-row p-4 flex items-center space-x-4 border-b"
    >
      <!-- User Number -->
      <div class="text-4xl text-info font-thin opacity-50 tabular-nums">
        {{ (index + 1).toString().padStart(2, '0') }}
      </div>

      <!-- User Profile Picture -->
      <div>
        <img
          v-if="user.profile_picture"
           :src="resolveImage(user.profile_picture)"
          alt="Profile"
          class="w-10 h-10 rounded-full"
          @error="e => e.target.src = '/uploads/profile_pictures/avatar.jpg'"
        />
        <div v-else class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">
          N/A
        </div>
      </div>

      <!-- User Info -->
      <div class="list-col-grow">
        <div>{{ user.first_name }} {{ user.last_name }}</div>
        <div class="text-xs uppercase font-semibold opacity-60">{{ user.email }}</div>
      </div>

      <!-- Details Button -->
      <button
        @click="goToDetails(user.id)"
        class="btn btn-square btn-ghost"
        title="Details"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-info">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
        </svg>
      </button>
    </li>
  </ul>







  <!-- Pagination Controls -->
  <div class="flex justify-center gap-4 mt-4">
    <button @click="prevPage" :disabled="currentPage === 1" class="btn btn-sm">⬅ Prev</button>
    <span class="text-sm">Page {{ currentPage }} of {{ totalPages }}</span>
    <button @click="nextPage" :disabled="currentPage === totalPages" class="btn btn-sm">Next ➡</button>
  </div>
</div>

<div v-else class="text-gray-400 italic">
  No users are currently assigned to this role.
</div>


    </div>
  </div>


</div>

</div>
</div>



</template>


<style scoped>
/* Styling for the list */
.list {
  width: 100%;
}

.list-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #e5e7eb;
}

.list-col-grow {
  flex-grow: 1;
}

.text-info {
  color: #3b82f6; /* Blue for "Info" */
}

.text-gray-500 {
  color: #6b7280; /* Light gray */
}

.text-xs {
  font-size: 0.875rem; /* Smaller font size */
}

.text-gray-700 {
  color: #2d3748; /* Darker gray for text */
}

.font-thin {
  font-weight: 300; /* Lighter font */
}

.opacity-50 {
  opacity: 0.5;
}

.bg-base-100 {
  background-color: #ffffff; /* Light background */
}

.bg-gray-200 {
  background-color: #e5e7eb;
}

.rounded-box {
  border-radius: 0.375rem;
}

.rounded-full {
  border-radius: 9999px;
}

.size-10 {
  width: 2.5rem;
  height: 2.5rem;
}

.size-6 {
  width: 1.5rem;
  height: 1.5rem;
}

.space-x-4 {
  margin-right: 1rem;
}

.p-4 {
  padding: 1rem;
}

.font-semibold {
  font-weight: 600;
}

.opacity-60 {
  opacity: 0.6;
}

.text-lg {
  font-size: 1.125rem;
}

.border-b {
  border-bottom-width: 1px;
  border-color: #e5e7eb;
}

/* Hover effect */
.list-row:hover {
  background-color: #f9fafb;
}
</style>

