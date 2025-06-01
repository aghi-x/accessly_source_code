<template>
  <div class="col-span-12 md:col-span-4">
    <div class="relative p-4 flex items-center gap-3 overflow-hidden">

      <!-- Background Icon -->
      <div class="absolute right-2 bottom-2 opacity-10 text-info z-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 stroke-current" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 10h11M9 21V3m12 11h-6" />
        </svg>
      </div>

      <!-- Foreground Content -->
      <div class="relative z-10 text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 stroke-current" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 10h11M9 21V3m12 11h-6" />
        </svg>
      </div>

      <div class="relative z-10">
        <h1 class="text-lg md:text-xl font-bold text-white">Dashboard Overview</h1>
        <p class="text-xs text-white">Summary of system insights</p>
      </div>

    </div>
  </div>
</template>
