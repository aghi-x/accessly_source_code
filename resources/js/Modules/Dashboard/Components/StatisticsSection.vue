<script setup>

defineProps({
  total_users: Number,
  online_users_count: Number,
  roles_count: Number,
  permissions_count: Number
})
</script>






<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Users -->
    <div class="stat relative bg-gradient-to-r from-blue-100 to-blue-200 rounded-box shadow overflow-hidden">
  <!-- Background Icon -->
  <div class="absolute right-2 bottom-2 opacity-10 text-primary z-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952
         4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15
         19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375
         6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75
         0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25
         0 2.625 2.625 0 0 1 5.25 0Z" />
    </svg>
  </div>
      
      <div class="flex">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="size-4 text-primary">        
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
        </svg>

      <div class="stat-title ml-1">Total Users</div>
      </div>


      <div class="stat-value text-primary">{{ total_users }}</div>
      <div class="stat-desc">Registered users</div>
    </div>



<!-- Online Users -->
<div class="stat relative bg-gradient-to-r from-blue-100 to-blue-200 rounded-box shadow overflow-hidden">
  <!-- Background Icon -->
  <div class="absolute right-2 bottom-2 opacity-10 text-success z-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808
           9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565
           20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
    </svg>
  </div>

  <!-- Foreground Content -->
  <div class="relative z-10">
    <div class="flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
           stroke-width="1.5" stroke="currentColor" class="size-4 text-success">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808
             9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565
             20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
      </svg>
      <div class="stat-title ml-1">Online Users</div>
    </div>
    <div class="stat-value text-success">{{ online_users_count }}</div>
    <div class="stat-desc">Currently active</div>
  </div>
</div>


<!-- Roles -->
<div class="stat relative bg-gradient-to-r from-blue-100 to-blue-200  rounded-box shadow overflow-hidden">
  <!-- Background Icon -->
  <div class="absolute right-2 bottom-2 opacity-10 text-info z-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" fill="none"
         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
    </svg>
  </div>

  <!-- Foreground Content -->
  <div class="relative z-10">
    <div class="flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24" stroke-width="1.5"
           stroke="currentColor" class="size-4 text-info">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
      </svg>
      <div class="stat-title ml-1">Roles</div>
    </div>
    <div class="stat-value text-info">{{ roles_count }}</div>
    <div class="stat-desc">User role types</div>
  </div>
</div>


<!-- Permissions -->
<div class="stat relative bg-gradient-to-r from-blue-100 to-blue-200  rounded-box shadow overflow-hidden">
  <!-- Background Icon -->
  <div class="absolute right-2 bottom-2 opacity-10 text-warning z-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" fill="none"
         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
    </svg>
  </div>

  <!-- Foreground Content -->
  <div class="relative z-10">
    <div class="flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24" stroke-width="1.5"
           stroke="currentColor" class="size-4 text-warning">
        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
      </svg>
      <div class="stat-title ml-1">Permissions</div>
    </div>
    <div class="stat-value text-warning">{{ permissions_count }}</div>
    <div class="stat-desc">Granular access</div>
  </div>
</div>


  </div>
</template>

