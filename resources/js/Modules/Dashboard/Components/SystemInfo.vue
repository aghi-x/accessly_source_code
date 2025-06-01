<script setup>

defineProps({
    laravel_version: String,
    php_version: String,
    system_uptime: String,
    database_status: String,
    log_size_mb: Number,
    disk_usage_percent: Number,
})
</script>


<template>
  <div class="stats stats-vertical shadow bg-base-100 rounded-box w-full h-full ">
    <!-- Uptime -->
    <div class="stat">
        <div class="text-sm font-semibold text-gray-500 flex mb-4">

          <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
              class="size-5 text-info mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" 
                  d="M6.75 3v2.25M17.25 3v2.25M3 6.75h2.25M18.75 6.75H21M6.75 18.75V21M17.25 18.75V21M3 17.25h2.25M18.75 17.25H21M9 9h6v6H9V9z" />
          </svg>
          System info
        </div>



      <div class="stat-title">Uptime</div>
      <div class="stat-value text-sm">{{ system_uptime }}</div>
      <div class="stat-desc">Server running time</div>
    </div>







    <div class="stat">
    <div class="stat-title">Database Status</div>

    <!-- Inline grid for status indicator -->
    <div class="inline-grid [grid-area:1/1]">
      <div 
        class="status" 
        :class="{
          'status-success': database_status === 'connected',
          'status-error': database_status !== 'connected'
        }"
        :aria-label="database_status === 'connected' ? 'Connected' : 'Error'"
      ></div>
    </div>

    <!-- Database Status Text -->
    <div :class="{
        'text-success': database_status === 'connected',
        'text-error': database_status !== 'connected'
      }" class="stat-value text-sm">
      {{ database_status === 'connected' ? 'Connected' : 'Error' }}
    </div>
    <div class="stat-desc">Current DB connection</div>
  </div>







    <!-- Log Size -->
    <div class="stat">
      <div class="stat-title">Log Size</div>
      <div class="stat-value text-sm">{{ log_size_mb }} MB</div>
      <div class="stat-desc">Storage usage</div>
    </div>







    <!-- Disk Usage -->
    <div class="stat">
      <div class="stat-title">Disk Usage</div>
      <div class="stat-value text-sm">{{ disk_usage_percent }}%</div>
      <progress class="progress progress-info w-56" :value="disk_usage_percent" max="100"></progress>
    
      <div class="stat-desc">Space occupied</div>
    </div>









    <!-- Laravel Version -->
    <div class="stat">
      <div class="stat-title">Laravel Version</div>
      <div class="stat-value text-sm">{{ laravel_version }}</div>
      <div class="stat-desc">Backend framework</div>
    </div>

    <!-- PHP Version -->
    <div class="stat">
      <div class="stat-title">PHP Version</div>
      <div class="stat-value text-sm">{{ php_version }}</div>
      <div class="stat-desc">Runtime environment</div>
    </div>

  </div>
</template>
