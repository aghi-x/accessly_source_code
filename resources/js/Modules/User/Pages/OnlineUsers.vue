<script setup>
import { computed } from 'vue'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import MenuButton from '@/Components/MenuButton.vue';
import OnlineUsersList from '../Components/OnlineUsersList.vue';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'


const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)

// ✅ Define props and assign them to "props"
const props = defineProps({
  online_users: Object,
  online_users_count: Number,
})

// ✅ Now use props.online_users, not online_users directly
const users = computed(() => props.online_users.data)
const links = computed(() => props.online_users.links)


</script>




<template>
    <div>
      <Head title="Online users" />
      <div class="grid grid-cols-12 gap-4">
        <!-- Left column (3/12) -->
        <div  v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">
        <LeftSidebar  @close-sidebar="sidebarOpen = false"/>
        </div>
        <!-- Right column (9/12) -->
        <div :class="['bg-base-100 p-4 transition-all duration-300', sidebarOpen ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10' : 'col-span-12']">
        <!-- Topbar with toggle button -->
        <MenuButton />
        <OnlineUsersList :users="users" :links="links" :online_users_count="online_users_count"/>

      </div>
    </div>
  </div>
  </template>
  
  