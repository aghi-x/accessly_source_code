<template>
  <div class="flex min-h-screen">
        <Head title="Features" />


    <Sidebar />

    <main class="flex-1 bg-gray-100 p-10 overflow-y-auto">
      <section id="features">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">✨ Features Overview</h1>
        <p class="mb-6">
          Accessly includes a powerful set of features that help you manage users, roles, permissions, and system configuration—right out of the box.
        </p>

        <!-- Authentication -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">🔐 Authentication</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>Login with secure email and password authentication</li>
          <li>Reset Password via email link</li>
          <li>Logout functionality</li>
          <li>Built using Laravel's built-in authentication features</li>
        </ul>

        <!-- Dashboard -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">📊 Dashboard</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>Displays system information (Laravel & PHP versions, server details)</li>
          <li>Shows recent user activity logs</li>
          <li>Dynamic statistics for:
            <ul class="list-disc pl-6 mt-1">
              <li>Total users</li>
              <li>Active admins</li>
              <li>Recent registrations</li>
              <li>Failed login attempts</li>
            </ul>
          </li>
          <li>Quick access to common actions (e.g., Add User)</li>
        </ul>

        <!-- User Management -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">👤 User Management (CRUD)</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>View all users in a searchable, paginated list</li>
          <li>Create, update, or delete users</li>
          <li>Assign roles to users directly</li>
          <li>Filter by roles or permissions</li>
        </ul>

        <!-- Online Users -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">🟢 Online Users</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>Real-time tracking of currently logged-in users</li>
          <li>Middleware-based session tracking system</li>
        </ul>

        <!-- Roles Management -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">🛡️ Roles Management (CRUD)</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>Create, edit, and delete roles</li>
          <li>Assign one or multiple roles to users</li>
          <li>View users by role</li>
        </ul>

        <!-- Permissions Management -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">🔑 Permissions Management (CRUD)</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>Create, edit, and delete permissions</li>
          <li>Assign permissions to specific roles</li>
          <li>View roles by permission</li>
          <li>(Optional) Assign permissions directly to users</li>
        </ul>

        <!-- Global Search -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">🔍 Global Search</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>A single search page to find:
            <ul class="list-disc pl-6 mt-1">
              <li>Users</li>
              <li>Roles</li>
              <li>Permissions</li>
            </ul>
          </li>
          <li>Real-time results with clickable links to each entity</li>
          <li>Improves navigation and saves time</li>
        </ul>

        <!-- User Profile -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">🙍‍♂️ User Profile</h2>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>View current user profile</li>
          <li>Edit profile information (name, email, etc.)</li>
          <li>Change password securely</li>
        </ul>

        <!-- Application Settings -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">⚙️ Application Settings</h2>
        <ul class="list-disc pl-6 space-y-1">
          <li>Update application name and logo</li>
          <li>Settings are stored in the database</li>
          <li>A simple UI for system configuration</li>
          <li>Changes reflect immediately in the interface</li>
        </ul>
      </section>
    </main>
  </div>
</template>

<script setup>
import Sidebar from '../Components/SideBar.vue'
import { Head } from '@inertiajs/vue3'

</script>
