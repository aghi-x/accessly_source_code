<template>
  <div class="flex min-h-screen">
        <Head title="Customize" />

    <Sidebar />

    <main class="flex-1 bg-gray-100 p-10 overflow-y-auto">
      <section id="customize">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">🛠️ How to Customize Accessly</h1>
        <p class="mb-6">
          Accessly is designed with a modular architecture, making it easy to extend, customize, or integrate into other Laravel projects.
          Both the backend (Laravel) and frontend (Vue 3 + Inertia.js) follow a structured and scalable approach.
        </p>

        <!-- Backend Structure -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">📂 Backend Structure (Laravel)</h2>
        <p class="mb-4">
          Each feature is organized as a self-contained module inside <code class="bg-gray-200 px-2 py-1 rounded">app/Modules/</code>, following a feature-first structure.
        </p>

        <h3 class="font-semibold text-lg mb-1">🔸 Key Backend Paths</h3>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li><code>app/Http/Models/User.php</code> — User model with relationships and traits</li>
          <li><code>app/Http/Controllers/Auth/</code> — Authentication logic (login, logout, password reset)</li>
          <li><code>app/Http/Middleware/</code> — Custom middlewares (e.g., online user tracking)</li>
        </ul>

        <p class="mb-2">🔹 Example: Role Module</p>
        <pre class="bg-white p-4 rounded shadow mb-6 text-sm">
app/Modules/Role/
├── Controller/RoleController.php
├── Services/RoleService.php
├── Interfaces/RoleControllerInterface.php
├── Interfaces/RoleServiceInterface.php
        </pre>

        <p class="mb-6">
          This pattern is used across all modules like <code>User</code>, <code>Permission</code>, <code>Setting</code>, <code>Search</code>, etc.
        </p>


          <div class="items-center space-y-1 mb-6">

          <img 
          :src="`/uploads/documentation_images/2.png`" 
          alt="User Profile" 
          class=""
          />

          </div>

          <div class="divider"></div>

          <div class="items-center space-y-1 mb-6">

          <img 
          :src="`/uploads/documentation_images/3.png`" 
          alt="User Profile" 
          class=""
          />

          </div>




        <!-- Frontend Structure -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-2">🎨 Frontend Structure (Vue 3 + Inertia.js)</h2>
        <p class="mb-4">
          All frontend logic is inside <code class="bg-gray-200 px-2 py-1 rounded">resources/js/Modules</code>. Each feature includes:
        </p>

        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li><strong>Pages/</strong> — Main view pages (list, create, edit)</li>
          <li><strong>Components/</strong> — Reusable components (forms, tables)</li>
        </ul>

        <p class="mb-2">🔹 Example: Role Module</p>
        <pre class="bg-white p-4 rounded shadow mb-6 text-sm">
resources/js/Modules/Role/
├── Pages/
│   ├── Roles.vue
│   ├── AddRole.vue
│   ├── EditRole.vue
│   └── RoleDetails.vue
└── Components/
    ├── RoleForm.vue
    └── RoleList.vue
        </pre>

        <p class="mb-6">The same applies to <code>User</code>, <code>Permission</code>, <code>Setting</code>, <code>Dashboard</code>, and <code>Search</code>.</p>




          <div class="items-center space-y-1 mb-6">

          <img 
          :src="`/uploads/documentation_images/1.png`" 
          alt="User Profile" 
          class=""
          />

          </div>

          <div class="divider"></div>

          <div class="items-center space-y-1 mb-6">

          <img 
          :src="`/uploads/documentation_images/1.png`" 
          alt="User Profile" 
          class=""
          />

          </div>
















        <!-- Common Tasks -->
        <h2 class="text-2xl text-blue-800 font-semibold mb-4">✏️ Common Customization Tasks</h2>

        <h3 class="font-semibold text-lg mb-1">1. Change App Name or Logo</h3>
        <p class="mb-6">Update in the Settings page (stored in the database).</p>

        <h3 class="font-semibold text-lg mb-1">2. Add a New Feature (e.g., Projects)</h3>
        <p class="mb-1">Backend:</p>
        <pre class="bg-white p-4 rounded shadow text-sm mb-2">
app/Modules/Project/
├── ProjectController.php
├── ProjectService.php
├── ProjectInterface.php
        </pre>
        <p class="mb-4">Also add routes in <code>routes/web.php</code></p>

        <p class="mb-1">Frontend:</p>
        <pre class="bg-white p-4 rounded shadow text-sm mb-6">
resources/js/Modules/Project/
├── Pages/
│   ├── Projects.vue
│   ├── AddProject.vue
│   ├── EditProject.vue
│   └── ProjectDetails.vue
└── Components/
    ├── ProjectList.vue
    └── ProjectForm.vue
        </pre>

        <h3 class="font-semibold text-lg mb-1">3. Edit Auth Behavior</h3>
        <ul class="list-disc pl-6 mb-6 space-y-1">
          <li>Controllers: <code>app/Http/Controllers/Auth/</code></li>
          <li>Views: none (Inertia handles the frontend)</li>
          <li>Middleware: <code>app/Http/Middleware/</code></li>
        </ul>

        <h3 class="font-semibold text-lg mb-1">4. Edit the User Model</h3>
        <p class="mb-4">
          Path: <code>app/Http/Models/User.php</code> — Add relationships or scopes like <code>roles()</code>, <code>activities()</code>, etc.
        </p>

        <h3 class="font-semibold text-lg mb-1">5. Edit a Role Page or Component</h3>
        <ul class="list-disc pl-6 space-y-1">
          <li>Edit roles list: <code>resources/js/Modules/Role/Pages/Roles.vue</code></li>
          <li>Edit form: <code>resources/js/Modules/Role/Components/RoleForm.vue</code></li>
          <li>Apply similar logic to modules like <code>User</code>, <code>Permission</code>, and <code>Setting</code></li>
        </ul>
      </section>
    </main>
  </div>
</template>

<script setup>
import Sidebar from '../Components/SideBar.vue'
import { Head } from '@inertiajs/vue3'

</script>
