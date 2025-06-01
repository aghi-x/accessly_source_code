<script setup>

defineProps({
    admins: Object,
})


</script>


<template>
  <div class="overflow-x-auto shadow-md">
    <ul class="h-full flex flex-col bg-base-100 rounded-box shadow-md p-4 text-sm text-gray-700 min-w-max whitespace-nowrap divide-y divide-gray-200">

      <!-- Section Title -->
      <li class="text-xs opacity-60 tracking-wide uppercase mb-3">Admins</li>

      <!-- Each Admin -->
      <li
        v-for="admin in admins"
        :key="admin.id"
        class="flex items-start gap-4 py-3 min-w-[600px]"
      >
        <!-- Icon or badge -->
        <div class="text-xl opacity-90">
          <img
            v-if="admin.profile_picture"
            :src="`${admin.profile_picture}`"
            alt="Profile"
            class="size-10 rounded-box object-cover"
              @error="e => e.target.src = '/uploads/profile_pictures/avatar.jpg'"

          />
        </div>

        <!-- Admin details -->
        <div class="list-col-grow">
          <div class="font-medium text-gray-800">
            {{ admin.email}}
          </div>
          <div class="text-xs text-gray-500">
            Joined: {{ new Date(admin.created_at).toLocaleString() }}
          </div>
        </div>
      </li>

    </ul>
  </div>
</template>
