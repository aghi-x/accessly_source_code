<script setup>
import LeftSidebar from '@/Components/LeftSidebar.vue'
import MenuButton from '@/Components/MenuButton.vue'
import { computed } from 'vue'
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'

const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)

</script>







  <template>
  <div class="grid grid-cols-12 gap-4">

    <Head title="Unauthorized" />

    <!-- Left Sidebar -->
    <div v-if="sidebarOpen" class="col-span-12 md:col-span-4 lg:col-span-3 xl:col-span-3">
      <LeftSidebar @close-sidebar="store.dispatch('closeSidebar')" />
    </div>

    <!-- Main Content -->
    <div
      :class="[
        'bg-base-100 p-4 transition-all duration-300',
        sidebarOpen
          ? 'col-span-12 md:col-span-8 lg:col-span-9 xl:col-span-9'
          : 'col-span-12'
      ]"
    >
      <MenuButton />

      <div class="text-center py-10">
      <h1 class="text-3xl font-bold text-red-500">403 - Access Denied</h1>
      <p class="mt-4">You do not have permission to view this page.</p>
    </div>


    </div>
  </div>
</template>
