<script setup>
import axios from 'axios'
import { ref } from 'vue'
import CheckSettings from './Components/CheckSettings.vue'
import { Head } from '@inertiajs/vue3'
import TopBar from './Components/TopBar.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  settings: Object,
  logoUrl: String,
})

const name = ref(props.settings?.name || '')
const logoPicture = ref(null)
const errors = ref({})
const processing = ref(false)
const preview = ref(props.logoUrl || null)
const settingRef = ref(null)
const loading = ref(false)
const success = ref(false)

function handleLogoChange(e) {
  logoPicture.value = e.target.files[0]
  preview.value = URL.createObjectURL(e.target.files[0])
}

async function submitForm() {
  processing.value = true
  errors.value = {}
  loading.value = true
  success.value = false

  const formData = new FormData()
  formData.append('name', name.value)
  if (logoPicture.value) {
    formData.append('logo_picture', logoPicture.value)
  }

  try {
    const res = await axios.post('/installer/settings', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })

    if (res.data.status === 'validation_failed') {
      errors.value = res.data.errors
      return
    }

    if (res.data.success) {
      success.value = true
      settingRef.value?.checkSettings()
    } else {
      alert(res.data.message || 'Something went wrong.')
    }

    router.visit('/login')

  } catch (error) {
    console.error(error)
    alert('Unexpected error occurred.')
  } finally {
    processing.value = false
    loading.value = false
  }
}
</script>

<template>
  <div>
    <Head title="Settings Setup" />

    <!-- Navbar -->
    <TopBar />

    <!-- Page container -->
    <div class="max-w-md mx-auto mt-10 p-4  shadow-md ">

      <!-- Steps -->
      <div class="card mb-4">
        <ul class="steps  steps-horizontal">
          <li class="step step-info">
            <a href="/installer/check">System</a>
          </li>
          <li class="step step-info">
            <a href="/installer/database">Database</a>
          </li>
          <li class="step step-info">
            <a href="/installer/admin">Admin</a>
          </li>
          <li class="step step-info">
            <a href="/installer/settings">Settings</a>
          </li>
        </ul>
      </div>

      <!-- Title -->
      <h2 class="text-xl font-bold mb-4">Step 3: App Name & Logo</h2>

      <!-- Loading -->
      <div v-if="loading" class="loading-overlay">
        <div class="loading-content">
          <p>Please wait ...</p>
          <span class="loading loading-ring loading-xl"></span>
        </div>
      </div>



      <!-- Form -->
      <form @submit.prevent="submitForm" class="space-y-4 mt-4">
        <div>
          <label class="block mb-1 font-medium">App Name</label>
          <input type="text" v-model="name" class="input" />
          <div v-if="errors.name" class="text-red-500 text-sm">{{ errors.name[0] }}</div>
        </div>

        <div>
          <label class="block mb-1 font-medium">Logo Picture</label>
          <input type="file" accept="image/*" @change="handleLogoChange" class="w-full file-input file-input-info hover:bg-blue-100" />
          <div v-if="errors.logo_picture" class="text-red-500 text-sm">{{ errors.logo_picture[0] }}</div>
        </div>

        <div v-if="preview" class="mt-4">
          <label class="block font-medium mb-1">Current Logo</label>
          <img :src="preview" alt="Logo Preview" class="h-20 rounded border" />
        </div>

        <button type="submit" :disabled="processing" class="btn btn-success w-full">
          🎉 Finish Setup & Go to Login →
        </button>
      </form>
      <!-- Optional server check -->
      <CheckSettings ref="settingRef" />
    </div>
  </div>
</template>

<style scoped>
.input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}
.btn {
  padding: 0.5rem 1rem;
  background-color: #2563eb;
  color: white;
  border: none;
  border-radius: 4px;
}
.btn-success {
  background-color: #22c55e;
  color: white;
}
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}
.loading-content {
  text-align: center;
  font-size: 1.5rem;
}
</style>
