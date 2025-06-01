<script setup>
import { ref } from 'vue'
import axios from 'axios'
import CheckDatabase from './Components/CheckDatabase.vue'
import TopBar from './Components/TopBar.vue'

const form = ref({
  db_host: '127.0.0.1',
  db_port: '3306',
  db_name: 'newdb9',
  db_user: 'root',
  db_password: 'root',
})

const errors = ref({})
const loading = ref(false)
const success = ref(false)
const checkKey = ref(0)
const submit = async () => {
  loading.value = true
  errors.value = {}
  success.value = false

  try {
    const response = await axios.post('/installer/database', form.value)

    if (response.data.status === 'validation_failed') {
      errors.value = response.data.errors
      return
    }

    if (response.data.errors?.db_error) {
      errors.value.db_error = response.data.errors.db_error[0]
      return
    }

    success.value = true
    console.log('Database configured successfully:', response.data)

    //Here i need to referesh the component <CheckDatabase />
    checkKey.value++

  } catch (error) {
    errors.value.db_error = 'Unexpected error. Please try again.'
    console.error(error)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div>
    <Head title="Database Setup" />

    <TopBar />


    <!-- Page container -->
    <div class="max-w-md mx-auto mt-10 p-4  shadow-md ">

      <!-- Steps navigation -->
      <div class="card mb-4">
        <ul class="steps steps-horizontal">
          <li class="step step-info">
              <a href="/installer/check">System</a>
            </li>
          <li class="step step-info">
            <a href="/installer/database">Database</a>
          </li>
          <li class="step">
            <a href="/installer/admin">Admin</a>
          </li>
          <li class="step">
            <a href="/installer/settings">Settings</a>
          </li>
        </ul>
      </div>

      <!-- Title -->
      <h2 class="text-xl font-bold mb-4">Step 1: Database Setup</h2>

      <!-- Loading spinner -->
      <div v-if="loading" class="loading-overlay">
        <div class="loading-content">
          <p>Please wait ...</p>
          <span class="loading loading-ring loading-xl"></span>
        </div>
      </div>


      <!-- DB Form -->
      <form @submit.prevent="submit" class="space-y-4 mt-4">
        <div>
          <label>DB Host</label>
          <input v-model="form.db_host" class="input" type="text" />
          <div class="text-red-500 text-sm" v-if="errors.db_host">{{ errors.db_host[0] }}</div>
        </div>

        <div>
          <label>DB Port</label>
          <input v-model="form.db_port" class="input" type="text" />
          <div class="text-red-500 text-sm" v-if="errors.db_port">{{ errors.db_port[0] }}</div>
        </div>

        <div>
          <label>Database Name</label>
          <input v-model="form.db_name" class="input" type="text" />
          <div class="text-red-500 text-sm" v-if="errors.db_name">{{ errors.db_name[0] }}</div>
        </div>

        <div>
          <label>DB Username</label>
          <input v-model="form.db_user" class="input" type="text" />
          <div class="text-red-500 text-sm" v-if="errors.db_user">{{ errors.db_user[0] }}</div>
        </div>

        <div>
          <label>DB Password</label>
          <input v-model="form.db_password" class="input" type="password" />
        </div>

        <div v-if="errors.db_error" class="text-red-500 text-sm">
          {{ errors.db_error }}
        </div>

        <div v-if="success" class="text-green-600 font-medium text-sm">
          ✅ Database connected and configuration saved!
        </div>

        <button :disabled="loading" class="btn btn-info  text-white w-full">Save Database</button>
      </form>

            <!-- Optional: connection test component -->
            <CheckDatabase :key="checkKey"/>
            
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
