<template>
  <div class="flex min-h-screen">
    <Head title="Introduction" />

    <!-- Sidebar -->
    <Sidebar />

    <!-- Content -->
    <main class="flex-1 bg-gray-100 p-10 overflow-y-auto">
      <section id="introduction">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Introduction</h1>



<div class="divider"></div>

<h2 class="text-xl font-semibold text-blue-800 mb-2 flex items-center gap-2">

  📘 About Accessly
</h2>


        <p class="mb-4">
          <strong>Accessly</strong> is a Laravel-based user management system designed to help developers and businesses
          manage authentication, roles, and permissions in a scalable and secure way. Whether you're building an internal tool,
          a SaaS product, or an admin panel, Accessly saves you hours of repetitive work by giving you a ready-to-use solution.
        </p>

        <div class="divider"></div>


        <h2 class="text-xl font-semibold text-blue-800 mb-2">🎯 Who Needs Accessly?</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>Laravel developers who build web apps with user roles</li>
          <li>SaaS builders who want authentication + access control out of the box</li>
          <li>Agencies or freelancers creating apps for clients</li>
          <li>Admin panel builders for internal tools or client dashboards</li>
        </ul>



        <h2 class="text-xl font-semibold text-blue-800 mb-2">🔑 Key Features</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>Secure login and password reset system</li>
          <li>Role & permission management</li>
          <li>Assign multiple roles to users</li>
          <li>Assign specific permissions to roles</li>
          <li>Dashboard with user activity overview</li>
          <li>Activity logs, system logs, and online user tracking</li>
          <li>Responsive design (mobile-first)</li>
          <li>Built with Laravel, Inertia.js, Vue 3, and Tailwind CSS</li>
        </ul>

        <h2 class="text-xl font-semibold text-blue-800 mb-2">💡 Use Cases</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>CRM or CMS with admin and staff access</li>
          <li>Project or team management tools</li>
          <li>E-commerce backend admin dashboards</li>
          <li>Membership platforms</li>
          <li>HR or employee management systems</li>
        </ul>

        <h2 class="text-xl font-semibold text-blue-800 mb-2">✅ Benefits</h2>
        <ul class="list-disc pl-6 space-y-1">
          <li>Save development time with ready-made user management</li>
          <li>Avoid re-inventing the wheel on every project</li>
          <li>Secure, scalable, and easy to extend</li>
          <li>Easily integrate with new or existing Laravel apps</li>
          <li>Professional code structure and UI design</li>
          <li>Includes full documentation for setup and customization</li>
        </ul>
      </section>
    </main>
  </div>
</template>


<script setup>
import Sidebar from '../Components/SideBar.vue'
import { Head } from '@inertiajs/vue3'

</script>

<style scoped>
/* Optional extra styling */
</style>
