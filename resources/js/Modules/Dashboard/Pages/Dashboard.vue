<script setup>
import { useStore } from 'vuex'
import { computed  } from 'vue'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import MenuButton from '@/Components/MenuButton.vue';
import DashboardTitle from '@/Modules/Dashboard/Components/DashboardTitle.vue';
import QuickActions from '@/Modules/Dashboard/Components/QuickActions.vue';
import StatisticsSection from '@/Modules/Dashboard/Components/StatisticsSection.vue';
import MostActiveUser from '@/Modules/Dashboard/Components/MostActiveUser.vue';
import LastAddedUsers from '@/Modules/Dashboard/Components/LastAddedUsers.vue';
import SystemInfo from '@/Modules/Dashboard/Components/SystemInfo.vue';
import LastUpdatedUsers from '@/Modules/Dashboard/Components/LastUpdatedUsers.vue';
import AdminsList from '@/Modules/Dashboard/Components/AdminsList.vue';
import FailedLogins from '@/Modules/Dashboard/Components/FailedLogins.vue';
import RecentActivities from '@/Modules/Dashboard/Components/RecentActivities.vue';
import { Head } from '@inertiajs/vue3'



const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)

const props = defineProps([
  'online_users_count',
  'total_users',
  'activities',
  'recentRegistration',
  'permissions_count',
  'roles_count',
  'laravel_version',
  'php_version',
  'system_uptime',
  'database_status',
  'log_size_mb',
  'disk_usage_percent',
  'failed_logins',
  'last_updated_users',
  'most_active_user',
  'recent_logins',
  'admins',
  'user',
])

</script>


<template>
  <div class="p-2">
    <Head title="Dashboard" />

    <div class="grid grid-cols-12 gap-2">

      <!-- Left Sidebar (Visible on larger screens) -->
      <div v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">
        <LeftSidebar @close-sidebar="sidebarOpen = false" />
      </div>

      <!-- Main Content Area -->
      <div :class="['bg-base-100 p-4 transition-all duration-300', sidebarOpen ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10' : 'col-span-12']">

        <!-- Topbar with Menu Toggle -->
        <MenuButton />



















        <!-- Dashboard Overview Section
        <div class="bg-white grid grid-cols-12 gap-1 p-1 rounded-[5px]">
          <DashboardTitle />
          <QuickActions />
        </div>

 -->







<!-- Dashboard Overview Section -->
<div class="relative grid grid-cols-12 gap-1 p-4 rounded-[10px] bg-gradient-to-r from-sky-500 via-blue-300 to-indigo-200 overflow-hidden shadow-md mt-2">

<!-- Background Icon or Image -->
<div class="absolute right-4 bottom-4 opacity-10 z-0 pointer-events-none">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-40 h-40 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h11M9 21V3m12 11h-6" />
  </svg>
  <!-- OR: Use an image
  <img src="/path/to/your/background-icon.svg" class="w-40 h-40" alt="Background Icon" />
  -->
</div>

<!-- Foreground Content -->
<div class="relative z-10 col-span-12">
  <DashboardTitle />
  <QuickActions />
</div>
</div>













        

        <!-- Main Dashboard Content (Stats, User Details, etc.) -->
        <div class="bg-[#f8f9fa] rounded-[5px] grid grid-cols-12 gap-1 p-1">
          <div class="col-span-12 md:col-span-9 white card">
            <div class="grid grid-cols-1 gap-4 p-2">
              <!-- Statistics Section -->
              <StatisticsSection 
                :total_users="total_users"
                :online_users_count="online_users_count"
                :roles_count="roles_count"
                :permissions_count="permissions_count"
              />

              <!-- Most Active User -->
              <MostActiveUser :most_active_user="most_active_user" />

              <!-- Recently Added Users -->
              <LastAddedUsers :recentRegistration="recentRegistration" />
            </div>
          </div>
        <!-- System Information Section -->

        <div class="card col-span-12 md:col-span-3 white mt-2 mb-2">
        <SystemInfo 
          :laravel_version="laravel_version"
          :php_version="php_version"
          :system_uptime="system_uptime"
          :database_status="database_status"
          :log_size_mb="log_size_mb"
          :disk_usage_percent="disk_usage_percent"
        />

      </div>




        </div>
        <!-- Activity and Admin Management Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 p-2 bg-[#f8f9fa] rounded-[5px] mt-4">
          <!-- Failed Login Attempts -->
          <FailedLogins :failed_logins="failed_logins" />
          
          <!-- Recent Activities -->
          <RecentActivities :activities="activities" />

          <!-- Last Updated Users -->
          <LastUpdatedUsers :last_updated_users="last_updated_users" />

          <!-- Admins List -->
          <AdminsList :admins="admins" />
        </div>

      </div> <!-- End of Main Content Area -->

    </div> <!-- End of Grid Container -->
  </div> <!-- End of Outer Div -->
</template>
