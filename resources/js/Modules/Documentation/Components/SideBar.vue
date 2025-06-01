<template>
  <aside class="w-64 bg-blue-800 text-white p-6 min-h-screen">
    <!-- Profile Picture -->
<div class="flex flex-col items-center space-y-1 mb-6">
  <a href="/">
    <img 
      :src="`/uploads/logos/logo.png`" 
      alt="User Profile" 
      class="w-32 h-32"
    />
  </a>
</div>

    <div class="divider divider-primary">Documentation</div>

    <nav class="space-y-2 mt-4">
      <a
        href="/documentation"
        :class="linkClass('/documentation')"
      >Introduction</a>

      <a
        href="/documentation/installation"
        :class="linkClass('/documentation/installation')"
      >Installation</a>

      <a
        href="/documentation/features"
        :class="linkClass('/documentation/features')"
      >Features</a>

      <a
        href="/documentation/customize"
        :class="linkClass('/documentation/customize')"
      >How to Customize</a>
    </nav>
  </aside>
</template>

<script setup>
const currentPath = window.location.pathname

const linkClass = (path) => {
  return [
    'block rounded px-2 py-1',
    currentPath === path ? 'bg-blue-600 font-bold' : 'hover:bg-blue-600'
  ].join(' ')
}
</script>
