<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
  settings: Object,
  logoUrl: String
})

const name = ref(props.settings?.name || '')
const logoPicture = ref(null)
const errors = ref({})
const processing = ref(false)
const preview = ref(props.logoUrl || null)
const loading = ref(false)
const isUpdated = ref(false)


function handleLogoChange(e) {
  logoPicture.value = e.target.files[0]
  preview.value = URL.createObjectURL(e.target.files[0])
}

async function submitForm() {
  processing.value = true;
  errors.value = {};
  loading.value = true;


  const formData = new FormData();
  formData.append('name', name.value);
  if (logoPicture.value) {
    formData.append('logo_picture', logoPicture.value);
  }

  try {
    const response = await axios.post('/settings', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    // Check if validation failed (even with 200 OK)
    if (response.data.success === false && response.data.errors) {
      errors.value = response.data.errors;
      return;
    }

    // Success
    flashUpdateFlag()

  } catch (error) {
    alert('Something went wrong.');
  } finally {
    processing.value = false;
    loading.value = false;

  }
}


function flashUpdateFlag() {
  isUpdated.value = true

  setTimeout(() => {
    isUpdated.value = false
  }, 3000) // 3 seconds
}





</script>





<template>
  <div class="card bg-base-100 shadow-md p-6">


        <!-- Success Notification Container -->
        <div
  v-if="isUpdated"
  class="fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 px-4"
>
  <div class="alert alert-success text-sm text-white shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 13l4 4L19 7" />
    </svg>
    <span>Settings updated successfully.</span>
  </div>
</div>






    <!-- Loading Overlay -->
    <div v-if="loading" class="loading-overlay">
      <div class="loading-content">
        <p class="text-lg font-semibold">Please wait ...</p>
        <span class="loading loading-ring loading-xl"></span>
      </div>
    </div>

    <!-- Card Body -->
    <div class="card-body">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">App Name & Logo</h1>
      </div>

      <!-- Form -->
      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- App Name -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">App Name</label>
          <input
            type="text"
            v-model="name"
            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500"
          />
          <div v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name[0] }}</div>
        </div>

        <!-- Logo Upload -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">Logo Picture</label>
          <input
            type="file"
            accept="image/*"
            @change="handleLogoChange"
            class="file-input file-input-info hover:bg-blue-100 "
          />
          <div v-if="errors.logo_picture" class="text-red-500 text-sm mt-1">{{ errors.logo_picture[0] }}</div>
        </div>

        <!-- Logo Preview -->
        <div v-if="preview" class="mt-6">
          <label class="block font-medium mb-2 text-gray-700">Current Logo</label>
          <img :src="preview" alt="Logo Preview" class="h-20 rounded-md border" />
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="processing"
          class="w-full bg-info text-white px-4 py-2 rounded-md hover:bg-blue-700 disabled:opacity-50"
        >

        
          Save Changes
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
/* Loading Overlay */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8); /* Light overlay */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999; /* Ensure it’s above other elements */
}

.loading-content {
  text-align: center;
  font-size: 1.25rem;
}

/* Form input & button styles */
input[type="text"], input[type="file"] {
  width: 100%;
  border-radius: 0.375rem;
  border: 1px solid #ddd;
  transition: border-color 0.3s ease;
}

input[type="text"]:focus, input[type="file"]:focus {
  border-color: #8982ff; /* Blue focus */
  outline: none;
}

/* Submit Button Styling */
button {
  font-weight: bold;
  transition: background-color 0.3s;
}

button:disabled {
  cursor: not-allowed;
}
</style>
