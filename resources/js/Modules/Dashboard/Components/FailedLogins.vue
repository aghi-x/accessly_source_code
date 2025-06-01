<script setup>

defineProps({
    failed_logins: Object,

})
</script>


<template>
  <div class="overflow-x-auto shadow-md">
    <ul class=" h-full flex flex-col bg-base-100 rounded-box shadow-md p-4 text-sm text-gray-700 min-w-max whitespace-nowrap divide-y divide-gray-200">

      <!-- Section Title -->
      <li class="text-xs opacity-60 tracking-wide uppercase mb-3">Failed Logins</li>

      <!-- Each Failed Login Entry -->
      <li
        v-for="log in failed_logins"
        :key="log.id"
        class="flex items-start gap-4 py-3 min-w-[600px]"
      >
        <div class="text-xl opacity-30">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-error">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.5a4.5 4.5 0 00-9 0v3M4.5 10.5h15M6 10.5v9h12v-9M10 14l4 4m0-4l-4 4" />
          </svg>


        </div>

        <div class="list-col-grow">
          <div class="font-medium text-gray-800">{{ log.properties.email }}</div>
          <div class="text-xs text-gray-500">
            IP: <span class="font-mono">{{ log.properties.ip }}</span>
          </div>

          <div class="text-xs text-gray-500">
          {{ new Date(log.created_at).toLocaleString() }}
        </div>

        </div>
      </li>

    </ul>
  </div>
</template>

