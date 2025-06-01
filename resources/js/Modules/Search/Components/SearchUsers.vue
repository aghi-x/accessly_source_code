<script setup>

import { router } from '@inertiajs/vue3'


function goToDetails(userId) {
  router.visit(`/users/${userId}`)
}


defineProps({
  users: Array
})

</script>



<template>
  <div v-if="users.length">
    <ul class="list bg-base-100 ">
      <!-- Section Title -->
      <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Users</li>

      <!-- List of Users -->
      <li
        v-for="(user) in users"
        :key="user.id"
        class="list-row p-4 bg-base-200 rounded-md flex justify-between items-center space-x-4"
      >


        <!-- User Profile Picture -->
        <div>
          <img
            v-if="user.profile_picture"
            :src="`${user.profile_picture}`"
            alt="Profile"
            class="w-12 h-12 rounded-full"
          />
          <div v-else class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">
            N/A
          </div>
        </div>

        <!-- User Info -->
        <div class="list-col-grow">
          <div class="text-sm font-semibold">{{ user.first_name }} {{ user.last_name }}</div>
          <div class="text-xs uppercase font-semibold opacity-60">{{ user.email }}</div>
        </div>

        <!-- View Details Button -->
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
  </div>
</template>

<style scoped>
/* Styling for list items */
.list-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-radius: 0.5rem;
}

.list-col-grow {
  flex-grow: 1;
}

/* Custom styling for icons */
.size-[1.2em] {
  width: 1.2em;
  height: 1.2em;
}

.size-10 {
  width: 2.5rem;
  height: 2.5rem;
}

.bg-base-200 {
  background-color: #f9fafb;
}

.bg-gray-200 {
  background-color: #e5e7eb;
}

.btn-square {
  width: 2rem;
  height: 2rem;
}

.btn-ghost {
  background: transparent;
  border: none;
}

/* Custom hover effect */
.list-row:hover {
  background-color: #e2e8f0;
}
</style>

