<script setup>

defineProps({
    last_updated_users: Object,

})
</script>

<template>
  <div class="overflow-x-auto shadow-md">
    <ul class=" h-full flex flex-col bg-base-100 rounded-box shadow-md p-4 text-sm text-gray-700 min-w-max whitespace-nowrap divide-y divide-gray-200">

      <!-- Section Title -->
      <li class="text-xs opacity-60 tracking-wide uppercase mb-3">Last Updated Users</li>

      <!-- Each User -->
      <li
        v-for="user in last_updated_users"
        :key="user.id"
        class="flex items-start gap-4 py-3 min-w-[600px]"
      >
        <!-- Icon or index -->
        <div class="text-xl opacity-70">

          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-warning">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 3l4 4-10 10H7V14L17 3z" />
          </svg>


        </div>

        <!-- User info -->
        <div class="list-col-grow">
          <div class="font-medium text-gray-800">{{ user.email}}</div>
          <div class="text-xs text-gray-500">
            {{ new Date(user.updated_at).toLocaleString() }}
          </div>
        </div>
      </li>

    </ul>
  </div>
</template>
