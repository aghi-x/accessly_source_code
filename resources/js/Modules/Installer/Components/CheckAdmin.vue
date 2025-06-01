<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// State to track admin existence and loading/error
const isAdminExist = ref(false)
const loading = ref(true)
const error = ref(null)

const checkAdmin = async () => {
  loading.value = true
  error.value = null

  try {
    const res = await axios.get('/installer/admin/check-admin')

    if (res.data.success) {
      isAdminExist.value = res.data.adminUserExists
    //  roleExists.value = res.data.roleExists
    } else {
      error.value = '❌ Could not check admin existence.'
    }

  //  console.log(res.data)
    
  } catch (err) {
   // console.error('Failed to check admin status:', err)
    error.value = '❌ Could not check admin existence.'
  } finally {
    loading.value = false
  }
}



const goToNextStep = () => {
  window.location.href = '/installer/settings'
}



// Run when component is mounted
onMounted(() => {
  checkAdmin()
})

defineExpose({ checkAdmin })
</script>

<template>
  <div>
    <!-- 🔄 Loading -->
    <div v-if="loading" class="text-center text-gray-600 py-4">
      <span class="loading loading-ring loading-md mr-2"></span>
      Checking admin status...
    </div>

    <!-- ❌ Error -->
    <div v-else-if="error" class="p-4 border rounded bg-red-50 text-red-800">
      <p class="text-sm font-medium"> {{ error }}</p>
    </div>

    <!-- ✅ Success or Warning -->
    <div v-else>
      <!-- Admin exists -->
      <div v-if="isAdminExist" class="p-4 border rounded bg-green-50 text-green-800 mb-4">
        <p class="mb-4 text-sm font-medium">✅ Admin user exists.</p>
        <button class="btn btn-success w-full text-white" @click="goToNextStep">
          Continue to App Settings →
        </button>
      </div>

      <!-- Admin missing -->
      <div v-else class="p-4 border rounded bg-red-50 text-red-800">
        <p class="text-sm font-semibold">❌ No admin user found. Please create one.</p>
      </div>
    </div>
  </div>
</template>
