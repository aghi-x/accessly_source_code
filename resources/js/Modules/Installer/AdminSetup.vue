<script setup>
import { ref } from 'vue'
import axios from 'axios'
import CheckAdmin from './Components/CheckAdmin.vue'
import TopBar from './Components/TopBar.vue'

const checkAdminRef = ref(null)

const form = ref({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: ''
})

const message = ref('')
const success = ref(false)
const errors = ref({})
const loading = ref(false)

const submit = async () => {
  loading.value = true
  success.value = false
  errors.value = {}
  message.value = ''

  try {
    const res = await axios.post('/installer/admin/set-credentiels', form.value)

    if (res.data.status === 'validation_failed') {
      errors.value = res.data.errors
      message.value = Object.values(res.data.errors)[0][0] // First error
      return
    }

    success.value = true
    message.value = res.data.message || 'Admin created successfully.'
    checkAdminRef.value?.checkAdmin()

  } catch (error) {
    console.error(error)
    message.value = 'Unexpected error. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div>
    <Head title="Admin Setup" />

    <!-- Navbar -->
    <TopBar />

    <!-- Page container -->
    <div class="max-w-md mx-auto mt-10 p-4  shadow-md ">

      <!-- Steps -->
      <div class="card mb-4">
        <ul class="steps steps-horizontal">
          <li class="step step-info">
            <a href="/installer/check">System</a>
          </li>
          <li class="step step-info">
            <a href="/installer/database">Database</a>
          </li>
          <li class="step step-info">
            <a href="/installer/admin">Admin</a>
          </li>
          <li class="step">
            <a href="/installer/settings">Settings</a>
          </li>
        </ul>
      </div>

      <!-- Title -->
      <h2 class="text-xl font-bold mb-4">Step 2: Create Admin Account</h2>

      <!-- Loading -->
      <div v-if="loading" class="loading-overlay">
        <div class="loading-content">
          <p>Please wait ...</p>
          <span class="loading loading-ring loading-xl"></span>
        </div>
      </div>


      <!-- Form -->
      <form @submit.prevent="submit" class="space-y-4 mt-4">
        <div>
          <label>First Name</label>
          <input v-model="form.first_name" class="input" type="text" required />
          <div v-if="errors.first_name" class="text-red-500 text-sm">{{ errors.first_name[0] }}</div>
        </div>

        <div>
          <label>Last Name</label>
          <input v-model="form.last_name" class="input" type="text" required />
          <div v-if="errors.last_name" class="text-red-500 text-sm">{{ errors.last_name[0] }}</div>
        </div>

        <div>
          <label>Email</label>
          <input v-model="form.email" class="input" type="email" required />
          <div v-if="errors.email" class="text-red-500 text-sm">{{ errors.email[0] }}</div>
        </div>

        <div>
          <label>Phone (optional)</label>
          <input v-model="form.phone" class="input" type="text" />
        </div>

        <div>
          <label>Password</label>
          <input v-model="form.password" class="input" type="password" required />
          <div v-if="errors.password" class="text-red-500 text-sm">{{ errors.password[0] }}</div>
        </div>

        <div>
          <label>Confirm Password</label>
          <input v-model="form.password_confirmation" class="input" type="password" required />
        </div>

        <button :disabled="loading" class="btn btn-info w-full">Create Admin</button>
      </form>

      <!-- Optional validation widget -->
      <CheckAdmin ref="checkAdminRef" />


      <!-- Message -->
      <div v-if="message" :class="{'text-green-600': success, 'text-red-600': !success}" class="mt-4 text-sm font-medium">
        {{ message }}
      </div>

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
