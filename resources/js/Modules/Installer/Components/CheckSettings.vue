<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const settingsExist = ref(false)
const loading = ref(true)
const error = ref(null)

const checkSettings = async () => {
  loading.value = true
  error.value = null

  try {
    const res = await axios.get('/installer/settings/check-setting')
    
    if (res.data.success) {
      settingsExist.value = res.data.configured
    }
  } catch (err) {
    error.value = 'Could not check application settings.'
  } finally {
    loading.value = false
  }
}


onMounted(() => {
  checkSettings()
})

// Expose method for parent refresh
defineExpose({ checkSettings })
</script>

<template>
  <div>
    <!-- 🔄 Loading -->
    <div v-if="loading" class="text-center text-gray-600 py-4">
      <span class="loading loading-ring loading-md mr-2"></span>
      Checking application settings...
    </div>

    <!-- ❌ Error -->
    <div v-else-if="error" class="p-4 border rounded bg-red-50 text-red-800">
      <p class="text-sm font-medium">❌ {{ error }}</p>
    </div>

    <!-- ✅ Success / ❌ Missing -->
    <div v-else>
      <!-- Settings exist -->
      <div v-if="settingsExist" class="p-4 border rounded bg-green-50 text-green-800 mb-4">
        <p class="text-sm font-medium">✅ Application settings exist.</p>
      </div>

      <!-- Settings missing -->
      <div v-else class="p-4 border rounded bg-red-50 text-red-800">
        <p class="text-sm font-medium">❌ Application settings are not configured yet.</p>
      </div>
    </div>
  </div>
</template>
