<script setup>
  
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import TopBar from './Components/TopBar.vue'


const props = defineProps({
  checks: Object
})

const allPassed = computed(() =>
  Object.values(props.checks).every((value) => value === true)
)
</script>









<template>
    <div>
      <Head title="System Check" />
  
        <TopBar />

      <!-- Page container -->
      <div class="max-w-md mx-auto mt-10 p-4 shadow-md">
  
        <!-- Steps navigation -->
        <div class="card">
          <ul class="steps steps-horizontal">
            <li class="step step-info">
              <a href="/installer/check">System</a>
            </li>
            <li class="step">
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
  
        <hr />
  
        <!-- Title -->
        <h2 class="text-xl font-bold mb-4">Step 0: System Requirements</h2>
  
        <!-- Requirements -->
        <ul class="space-y-2">
          <li v-for="(value, key) in checks" :key="key" class="flex items-center">
            <span v-if="value" class="text-green-600">✅</span>
            <span v-else class="text-red-600">❌</span>
            <span class="ml-2">{{ key }}</span>
          </li>
        </ul>
  
        <div class="mt-6 text-sm text-gray-600">
          <p>All requirements should be green to proceed with the installation.</p>
        </div>
  
        <!-- Continue button -->
        <div class="mt-6">
          <a
            href="/installer/database"
            class="btn btn-success text-white"
            :class="{ 'btn-disabled': !allPassed }"
          >
            Continue to Database Setup →
          </a>
        </div>
  
      </div>
    </div>
  </template>
  
