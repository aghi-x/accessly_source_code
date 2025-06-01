<script setup>
import { Link } from '@inertiajs/vue3';

</script>
<template>
  <div class="card col-span-12 md:col-span-8">
    <div class="card-body">
      <h2 class="card-title text-sm font-semibold text-white">Quick Actions</h2>

      <!-- Buttons -->
      <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">

        <!-- Reusable Gradient Button -->
        <Link href="/users/add" class="btn btn-sm text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700   border-0 shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
               viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Add User
        </Link>

        <Link href="/roles/add" class="btn btn-sm text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700  border-0 shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
               viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Add Role
        </Link>

        <Link href="/permissions/add" class="btn btn-sm text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700  border-0 shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
               viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Add Permission
        </Link>

      </div>
    </div>
  </div>
</template>

