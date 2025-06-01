<script setup>

defineProps({
    permissions: Object,

})
</script>






<template>
  <!-- Permissions Section -->
  <div class="space-y-6">
    <!-- Divider -->
    <div class="divider">Permissions</div>
    <div class="border-t border-gray-300 my-4"></div>

    <div v-if="permissions.length > 0" class="space-y-4">
    <!-- Permissions Badges -->
    <p class="font-semibold">Assigned Permissions</p>
    <div class="flex flex-wrap gap-2">
      <span
        v-for="(permission, index) in permissions"
        :key="permission.id"
        class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"
      >
        {{ permission.name }}
        <span v-if="index < permissions.length - 1"></span>
      </span>
    </div>
  </div>

    <!-- No Permissions Message -->
    <div v-else class="text-gray-400 italic text-lg">
      No permissions assigned.
    </div>
  </div>
</template>

<style scoped>
/* Styling for the Divider */
.text-xl {
  font-size: 1.25rem;
  font-weight: bold;
  color: #4b5563; /* Dark gray */
}

.border-t {
  border-top-width: 1px;
  border-color: #e5e7eb;
}

.my-4 {
  margin-top: 1rem;
  margin-bottom: 1rem;
}

/* Styling for Permissions Table */
table {
  width: 100%;
  border-collapse: collapse;
}

td {
  padding: 1rem;
  text-align: left;
}

.text-sm {
  font-size: 0.875rem; /* Smaller font size */
}

.text-gray-700 {
  color: #2d3748; /* Darker gray */
}

.text-gray-400 {
  color: #cbd5e0;
}

.italic {
  font-style: italic;
}

.hover\:bg-gray-50:hover {
  background-color: #f9fafb;
}

.border-b {
  border-bottom-width: 1px;
  border-color: #e5e7eb;
}
</style>
