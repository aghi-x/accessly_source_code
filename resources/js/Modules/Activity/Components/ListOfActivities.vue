<script setup>
import { router } from '@inertiajs/vue3'


defineProps({
    activities: Object,
    links: Object,
})
</script>





<template>
  <div class="p-6 max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">📝 Activity Log</h1>
    </div>

    <!-- No Activities Message -->
    <div v-if="activities.length === 0" class="text-gray-500">
      No activity found.
    </div>

    <!-- Activity Table with Horizontal Scrolling -->
    <div v-if="activities.length > 0" class="overflow-x-auto">
      <table class="min-w-full table-auto bg-white shadow rounded-lg">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="px-4 py-2 font-medium text-sm text-gray-700">Description</th>
            <th class="px-4 py-2 font-medium text-sm text-gray-700">Causer</th>
            <th class="px-4 py-2 font-medium text-sm text-gray-700">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="activity in activities" :key="activity.id" class="hover:bg-gray-50 border-b">
            <td class="px-4 py-3 text-sm text-gray-700">
              <strong>{{ activity.description }} {{ activity.properties.email }} {{ activity.properties.role_name }} {{ activity.properties.new_name }} {{ activity.properties.permission_name }}  </strong>
            </td>
            <td class="px-4 py-3 text-sm text-gray-700">
              <span v-if="activity.causer">
                {{ activity.causer.email }}
              </span>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">
              {{ new Date(activity.created_at).toLocaleString() }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="links.length > 3" class="flex justify-center space-x-2 mt-6">
      <template v-for="(link, index) in links" :key="index">
        <button
          v-if="link.url"
          @click="router.visit(link.url, { preserveScroll: true })"
          class="px-3 py-1 rounded-md text-sm"
          :class="{
            'bg-blue-500 text-white': link.active,
            'bg-gray-200 hover:bg-gray-300': !link.active
          }"
          v-html="link.label"
        />
      </template>
    </div>
  </div>
</template>







<style scoped>
/* Table styling */
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  text-align: left;
}

th {
  background-color: #f3f4f6;
}

tbody tr {
  transition: background-color 0.2s;
}

tbody tr:hover {
  background-color: #f9fafb;
}

/* Pagination button styling */


button:hover {
  opacity: 0.8;
}
</style>
