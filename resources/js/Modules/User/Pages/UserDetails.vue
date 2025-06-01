<script setup>
import { computed } from 'vue'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import MenuButton from '@/Components/MenuButton.vue';
import { Link } from '@inertiajs/vue3'
import UserInfo from '@/Modules/User/Components/UserInfo.vue';
import UserRoles from '@/Modules/User/Components/UserRoles.vue';
import UserPermissions from '@/Modules/User/Components/UserPermissions.vue';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const props = defineProps({
  user: Object,
  permissions: Object,
});

</script>



<template>


<div>

<div class="grid grid-cols-12 gap-4">
  <Head title="User details" />
<!-- Left column (3/12) -->
<div  v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">

<LeftSidebar  @close-sidebar="sidebarOpen = false"/>

</div>

<!-- Right column (9/12) -->
<div :class="['bg-base-100 p-4 transition-all duration-300', sidebarOpen ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10' : 'col-span-12']">

                <!-- Topbar with toggle button -->
                <MenuButton />
  <!-- Add User Button -->
  <Link href="/users/add" class="btn btn-info text-white btn-sm ml-10">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
    Add User
  </Link>

  <!-- All Users Button -->
  <Link href="/users" class="btn btn-info text-white btn-sm ml-10">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="size-4 text-white">        
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
        </svg>
    All Users
  </Link>

  <!-- Edit User Info Button -->
  <Link :href="`/users/${user.id}/edit`" class="btn btn-info text-white btn-sm ml-10">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M17 3l4 4-10 10H7V14L17 3z" />
    </svg>
    Edit User Info
  </Link>

    <div class="card bg-base-100 ">
        <div class="card-body">

                <UserInfo :user="user"/>

                <UserRoles  :user="user"/>

                <UserPermissions :permissions="permissions"/>

      </div>
  </div>


</div>

</div>

</div>



</template>
