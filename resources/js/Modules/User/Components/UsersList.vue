<script setup>
import { router } from '@inertiajs/vue3'


defineProps({
  users: {
    type: Array,
    required: true,
  },
  links: {
    type: Array,
    required: true
  }
});


defineEmits(['edit', 'delete'])
function goToEdit(userId) {
  router.visit(`/users/${userId}/edit`)
}

function goToDetails(userId) {
  router.visit(`/users/${userId}`)
}

</script>

<template>



  <div class="overflow-x-auto sm:overflow-visible md:overflow-visible bg-base-100">
    <table class="table w-full">
      <!-- Table Head -->
      <thead class="bg-base-200 text-base-content">
        <tr>
          <th>Profile Picture</th>
          <th>First name</th>
          <th>Last name</th>
          <th>Email</th>
          <th>Phone</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>

      <!-- Table Body -->
      <tbody>
        <tr v-for="user in users" :key="user.id" class="hover">
          <!-- <td>
            <span v-if="user.is_online" class="text-success text-lg">🟢</span>
            <span v-else class="text-gray-400 text-lg">⚪</span>
          </td> -->
          <td>







            <div v-if="user.profile_picture" class="flex flex-col items-center">
              <img :src="`${user.profile_picture}`" alt="Profile" class="w-12 h-12 rounded-full mt-2"  @error="e => e.target.src = '/uploads/profile_pictures/avatar.jpg'"/>
            </div>





          </td>
          <td>{{ user.first_name }}</td>
          <td>{{ user.last_name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.phone_number }}</td>

          <td class="flex gap-2 justify-center items-center mt-1">


            <button
              @click="goToEdit(user.id)"
              class="btn btn-square btn-ghost "
              title="Edit"
            >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-warning">
              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>

            </button>
            <button
              @click="$emit('delete', user.id)"
              class="btn btn-square btn-ghost"
              title="Delete"
            >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-error">
              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>

            </button>
            <button
              @click="goToDetails(user.id)"
              class="btn btn-square btn-ghost"
              title="Details"
            >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-info">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
            </svg>

            </button>
          </td>
        </tr>
      </tbody>
    </table>


    <div v-if="links.length > 3" class="flex justify-center space-x-2 mt-6">
  <template v-for="(link, index) in links" :key="index">
    <button
      v-if="link.url"
      @click="router.visit(link.url, { preserveScroll: true })"
      class="px-3 py-1 rounded"
      :class="{
        'bg-blue-500 text-white': link.active,
        'bg-gray-200 hover:bg-gray-300': !link.active
      }"
      v-html="link.label"
    />
  </template>
</div>
  </div>
</template>
