<script setup>
import ConfirmDialog from '@/Components/ConfirmDialog.vue';
import { Link, usePage } from '@inertiajs/vue3'
import { useStore } from 'vuex'
import { ref, computed  } from 'vue'
import { router } from '@inertiajs/vue3'


const page = usePage()

const appSettings = computed(() => page.props.appSettings)

const appName = computed(() => appSettings.value?.app_name || 'App Name')
// const logoUrl = computed(() => appSettings.value?.logo_picture || '/storage/logos/logo.png')




  const logoUrl = computed(() => {
    const value = appSettings.value?.logo_picture;

    if (!value) {
      return '/uploads/logos/logo.png'; // fallback
    }

    // If it's a full URL and contains "/storage/", replace it with "/uploads/"
    if (value.startsWith('http') && value.includes('/storage/')) {
      return value.replace('/storage/', '/uploads/');
    }

    // If it's already correct
    if (value.startsWith('http') || value.startsWith('/uploads')) {
      return value;
    }

    // If it's a relative path like "logos/xyz.png"
    return `/uploads/${value}`;
  });





const showLogoutDialog = ref(false)
const logoutDialogMessage = ref('Are you sure you want to log out?')
const store = useStore()
const fullName = computed(() => store.getters['userProfile/fullName'])




function confirmLogout() {
  showLogoutDialog.value = true
}

function performLogout() {
  router.post('/logout')
}



const profilePicture = computed(() => {
  const value = store.getters['userProfile/profilePicture'];

  if (!value || value === 'null') return null;

  let path = '';

  // Normalize path
  if (value.includes('/storage/')) {
    path = value.replace('/storage/', '/uploads/');
  } else if (value.startsWith('http') || value.startsWith('/uploads')) {
    path = value;
  } else {
    path = `/${value.replace(/^\/+/, '')}`;
  }

  // 🔥 Fully-qualified absolute path
  if (path.startsWith('/')) {
    return `${window.location.origin}${path}`;
  }

  return path;
});





// Basic active route matcher
const isActive = (route) => page.url === route



</script>



<template>


    <aside class="h-full min-h-screen w-full p-6 flex flex-col gap-6 m-4 bg-white rounded-[5px] border-r border-gray-300 pb-4">







<!-- Modern Logo and Profile Section -->
<div class="bg-white rounded-xl shadow p-4 flex flex-col items-center space-y-3">
  <!-- Logo -->
  <div class="bg-[#001b46] rounded-full p-1">
    <img 
      :src="logoUrl"  
      alt="EfficSoft Logo" 
      class="w-20 h-20 object-cover rounded-full border-4 border-white shadow-md"
    />
  </div>



  <!-- Tagline -->
  <p class="text-sm text-gray-400 tracking-wide">{{appName}}</p>
  <p class="text-xs text-gray-400 tracking-wide">Manage users and roles</p>

  <!-- Profile Picture -->
  <div v-if="profilePicture" class="flex flex-col items-center space-y-1">
    <img 
      :src="profilePicture" 
      alt="User Profile" 
      class="w-16 h-16 rounded-full object-cover border border-gray-300 shadow"
    />
  </div>

  <!-- Full Name -->
  <div class="text-sm font-medium text-gray-700">{{ fullName }}</div>
</div>







<ConfirmDialog
  v-model="showLogoutDialog"
  title="Confirm Logout"
  :message="logoutDialogMessage"
  @confirm="performLogout"
  @cancel="showLogoutDialog = false"
/>




      <!-- Menu -->
      <nav class="flex flex-col gap-2">
  
        <div class="divider my-1 text-sm text-gray-500">
          Main
          </div>
  
        <Link
          href="/dashboard"
          class="btn btn-ghost justify-start"
          :class="{ 'bg-white font-bold text-info': isActive('/dashboard') }"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-4 text-info">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 3.75h6.5v6.5h-6.5v-6.5zm0 10h6.5v6.5h-6.5v-6.5zm10 0h6.5v6.5h-6.5v-6.5zm0-10h6.5v6.5h-6.5v-6.5z" />
        </svg>
         Dashboard
        </Link>
  
        <Link
          href="/profile"
          class="btn btn-ghost justify-start"
          :class="{ 'bg-base-300 font-bold text-info': isActive('/profile') }"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-4 text-info">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 1115 0H4.5z" />
        </svg>
          Profile
        </Link>
  
        <div class="divider my-1  text-sm text-gray-500">User Management</div>
  
        <Link
          href="/search"
          class="btn btn-ghost justify-start"
          :class="{ 'bg-base-300 font-bold text-info': isActive('/search') }"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
     class="size-4 text-info">
  <path stroke-linecap="round" stroke-linejoin="round"
        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
</svg>

        
        Search
        </Link>

        <Link
          href="/users"
          class="btn btn-ghost justify-start"
          :class="{ 'bg-base-300 font-bold text-info': isActive('/users') }"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="size-4 text-info">        
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
        </svg>
        
         Users
        </Link>
  
        <Link
          href="/users/online"
          class="btn btn-ghost justify-start"
          :class="{ 'bg-base-300 font-bold text-info': isActive('/users/online') }"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-info">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
        </svg>
         Online Users
        </Link>
  
        <Link
          href="/roles"
          class="btn btn-ghost justify-start"
          :class="{ 'bg-base-300 font-bold text-info': isActive('/roles') }"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4  text-info">
          <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
        </svg>
         Roles
        </Link>
  
        <Link
          href="/permissions"
          class="btn btn-ghost justify-start"
          :class="{ 'bg-base-300 font-bold text-info': isActive('/permissions') }"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4  text-info">
          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
        </svg>
        
        
        
         Permissions
        </Link>
  
        <div class="divider my-1  text-sm text-gray-500">System</div>
  
        <Link
          href="/activity-log"
          class="btn btn-ghost justify-start"
          :class="{ 'bg-base-300 font-bold text-info': isActive('/activity-log') }"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-4 text-info">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

         Activities
        </Link>

        <!-- ✅ New Settings Link -->
          <Link
            href="/settings"
            class="btn btn-ghost justify-start"
            :class="{ 'bg-base-300 font-bold text-info': isActive('/settings') }"
          >
          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              class="size-4 text-info">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.01c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.01 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.01 2.573c.94 1.543-.827 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.01c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.572-1.01c-1.543.94-3.31-.827-2.37-2.37a1.724 1.724 0 00-1.01-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.01-2.572c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.01zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>

                  
        
        Settings
</Link>


  
        <button
          class="btn btn-ghost justify-start text-error"
          :class="{ 'bg-red-100 text-red-700 font-bold': isActive('/logout') }"
           @click.prevent="confirmLogout"
        >
          
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-4 text-danger">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3-3h-8.25m0 0l3-3m-3 3l3 3" />
        </svg>

        Logout
        </button>
  
      </nav>
      
    </aside>
  </template>
  
