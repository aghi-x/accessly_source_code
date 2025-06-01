<script setup>

import { router } from '@inertiajs/vue3'


function goToDetails(permissionId) {
  router.visit(`/permissions/${permissionId}`)
}


defineProps({
  permissions: Array
})
</script>


<template>
  <div v-if="permissions.length">
    <!-- Permissions List -->
    <ul class="list bg-base-100">
      <!-- Section Title -->
      <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">
        Permissions
      </li>

      <!-- List of Permissions -->
      <li
        v-for="(permission) in permissions"
        :key="permission.id"
        class="list-row p-4 bg-base-200 rounded-md flex justify-between items-center space-x-4"
      >


        <!-- Permission Info -->
        <div class="list-col-grow">
          <div class="text-sm font-semibold">{{ permission.name }}</div>
        </div>

        <!-- View Details Button -->
        <button
          @click="goToDetails(permission.id)"
          class="btn btn-square btn-ghost"
          title="Details"
        >


            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6  text-info">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
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
