<script setup>
import { computed } from 'vue'
import LeftSidebar from '@/Components/LeftSidebar.vue'
import MenuButton from '@/Components/MenuButton.vue'
import AppSettingForm from '../Components/AppSettingForm.vue'
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'

const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const props = defineProps({
  settings: Object,
  logoUrl: String
})

</script>

<template>
  <div class="grid grid-cols-12 gap-4">
    <Head title="Setting" />
    <!-- Left Sidebar -->
    <div v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">
      <LeftSidebar @close-sidebar="store.dispatch('closeSidebar')" />
    </div>

    <!-- Main Content -->
    <div
      :class="[
        'bg-base-100 p-4 transition-all duration-300',
        sidebarOpen
          ? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10'
          : 'col-span-12'
      ]"
    >
      <MenuButton />


      <AppSettingForm :settings="settings" :logo-url="logoUrl" />
    </div>
  </div>
</template>
