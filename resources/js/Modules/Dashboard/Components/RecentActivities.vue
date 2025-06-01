<script setup>

defineProps({
    activities: Object,

})
</script>

<template>
  <div class="overflow-x-auto shadow-md">
    <ul class=" h-full flex flex-col bg-base-100 rounded-box shadow-md p-4 text-sm text-gray-700 min-w-max whitespace-nowrap divide-y divide-gray-200">

      <!-- Section Title -->
      <li class="text-xs opacity-60 tracking-wide uppercase mb-3">Recent Activities</li>

      <!-- Each Activity -->
      <li
        v-for="activity in activities"
        :key="activity.id"
        class="flex items-start gap-4 py-3"
      >
        <!-- Icon or marker -->
        <div class="text-xl">        
          
          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 text-info">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        
        </div>

        <!-- Description and timestamp -->
        <div class="list-col-grow">
          <div class="font-medium text-gray-800">{{ activity.description }}</div>
          <div class="text-sm text-gray-600">
            {{ activity.properties.email }}
          </div>
          <div class="text-sm text-gray-600">
            {{ activity.properties.role_name }}
          </div>
          <div class="text-sm text-gray-600">
         {{ activity.properties.new_name }} 
          </div>

          <div class="text-sm text-gray-600">
         {{ activity.properties.permission_name }} 
          </div>

          <div class="text-xs text-gray-500">
            {{ new Date(activity.created_at).toLocaleString() }}
          </div>
        </div>
      </li>

    </ul>
  </div>
</template>
