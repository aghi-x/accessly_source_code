<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const loading = ref(true)
const results = ref({})
const success = ref(false)


const goToNextStep = () => {
window.location.href = '/installer/admin'
}


onMounted(async () => {
  try {
    const response = await axios.get('/installer/checkdb')

    if (response.data.success) {
      results.value = response.data.results

      // Check if all tables exist (true/false per table)
      success.value = Object.values(results.value).every(Boolean)
    }
    // else {
    //   console.error('Check failed:', response.data.message)
    // }

  } catch (error) {
    console.error('Failed to check database:', error)
  } finally {
    loading.value = false
  }
})


</script>


<template>
  <div>
    <div v-if="loading" class="text-center text-gray-600 py-4">
      <span class="loading loading-ring loading-md mr-2"></span>
      Checking database...
    </div>

    <div v-else>
      <!-- ✅ Success -->
      <div v-if="success" class="p-4 border rounded bg-green-50 text-green-800 mb-4">
        <p class="mb-4 text-sm font-medium">✅ All required tables are present.</p>
        <button class="btn btn-success w-full text-white" @click="goToNextStep">
          Continue to Admin Setup →
        </button>
      </div>

      <!-- ❌ Failure -->
      <div v-else class="p-4 border rounded bg-red-50 text-red-800">
        <p class="mb-2 text-sm font-semibold">❌ The database has not been configured yet.</p>

        <p class="text-sm mb-2">Missing tables:</p>



<ul
  v-if="Object.keys(results).length"
  class="list-disc list-inside text-sm space-y-1 ml-2"
>
  <li v-for="(exists, table) in results" :key="table" v-if="!exists">
    {{ table }}
  </li>
</ul>





<!-- 
        <ul class="list-disc list-inside text-sm space-y-1 ml-2">
          <li v-for="(exists, table) in results" :key="table" v-if="!exists">
            {{ table }}
          </li>
        </ul> -->
















      </div>
    </div>
  </div>
</template>