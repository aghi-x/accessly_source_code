<script setup>
import { computed } from 'vue'

const props = defineProps({ status: Number })

const title = computed(() => ({
  503: '503: Service Unavailable',
  500: '500: Server Error',
  404: '404: Page Not Found',
  403: '403: Forbidden',
}[props.status] || `${props.status}: Error`))

const description = computed(() => ({
  503: 'Sorry, we are doing some maintenance. Please check back soon.',
  500: 'Whoops, something went wrong on our servers.',
  404: 'Sorry, the page you are looking for could not be found.',
  403: 'Sorry, you are forbidden from accessing this page.',
}[props.status] || 'Something went wrong.'))
</script>

<template>
  <div class="text-center my-24">
    <h1 class="text-3xl font-bold">{{ title }}</h1>
    <p class="text-gray-500 mt-4">{{ description }}</p>
  </div>
</template>
