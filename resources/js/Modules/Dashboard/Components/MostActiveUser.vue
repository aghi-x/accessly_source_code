<script setup>

import { router } from '@inertiajs/vue3'


function goToDetails(userId) {
  router.visit(`/users/${userId}`)
}

defineProps({
most_active_user: Object,
})
</script>


<template>

<div class="card bg-white">
      <ul class="list">
        <li class="list-row">
          <!-- Index or badge (optional) -->
          <div class="text-4xl text-info font-thin opacity-50 tabular-nums">★</div>

          <!-- Profile Picture -->
          <div>
            <img
              v-if="most_active_user.profile_picture"
              :src="`${most_active_user.profile_picture}`"
              alt="Profile"
              class="size-10 rounded-full"
                @error="e => e.target.src = '/uploads/profile_pictures/avatar.jpg'"
            />
            <div v-else class="size-10 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">
              N/A
            </div>
          </div>

          <!-- User Details -->
          <div class="list-col-grow">
            <div>{{ most_active_user.first_name }} {{ most_active_user.last_name }}</div>
            <div class="text-xs uppercase font-semibold opacity-60">Most Active User</div>
          </div>

          <!-- Action Button -->
          <button
            @click="goToDetails(most_active_user.id)"
            class="btn btn-square btn-ghost"
            title="Details"
          >
            <!-- <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor">
                <path d="M6 3L20 12 6 21 6 3z" />
              </g>
            </svg> -->

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-info">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
            </svg>

            
          </button>
        </li>
      </ul>

    </div>
</template>
