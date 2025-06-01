<template>
  <div class="flex min-h-screen">
    <Head title="Installation" />

    <Sidebar />

    <main class="flex-1 bg-gray-100 p-10 overflow-y-auto">
      <section id="installation">
        <!-- Page Title -->
        <h1 class="text-3xl font-bold text-gray-900 mb-6">🧩 Installation Options</h1>



        <!-- Introduction -->
        <p class="mb-6 text-gray-700">
          <strong>Accessly</strong> is available in two versions depending on your technical needs and deployment environment:
        </p>

        <!-- Prebuilt Version -->
        <div class="mb-12">
          <h2 class="text-2xl font-semibold text-blue-800 mb-2">✅ 1. Prebuilt Version</h2>
          <p class="italic mb-4 text-gray-600">For Web Hosting or Local Server</p>
          <p class="mb-4 text-gray-700">
            This version is ideal for users who want to quickly deploy Accessly without using developer tools.
          </p>

          <h3 class="text-xl font-semibold text-gray-800 mb-2">🔹 Use Cases</h3>
          <ul class="list-disc pl-6 mb-4 text-gray-700">
            <li>Hosting platforms</li>
            <li>Local servers like XAMPP, Laragon, or MAMP</li>
          </ul>

          <h3 class="text-xl font-semibold text-gray-800 mb-2">🛠️ Setup Instructions</h3>
          <ol class="list-decimal pl-6 space-y-2 text-gray-700">


          <li>
            Upload and extract the folder to the correct web root based on your environment:
            <ul class="list-disc pl-6 mt-1">
              <li><code>public_html/</code> – <strong>For cPanel (Shared Hosting)</strong></li>
              
              <li><code>/var/www/html</code> – <strong>Linux (Apache)</strong></li>
              <li><code>/usr/share/nginx/html</code> – <strong>Linux (Nginx)</strong></li>
              
              <li><code>C:\xampp\htdocs</code> – <strong>Windows (XAMPP + Apache)</strong></li>
              <li><code>C:\nginx\html</code> – <strong>Windows (Nginx – manual install)</strong></li>
              
              <li><code>/Applications/XAMPP/htdocs</code> – <strong>macOS (XAMPP)</strong></li>
              <li><code>/Library/WebServer/Documents</code> – <strong>macOS (Apache)</strong></li>
              <li><code>/usr/local/var/www</code> – <strong>macOS (Nginx via Homebrew)</strong></li>
            </ul>
          </li>


<div class="bg-green-100 border border-green-300 text-green-900 rounded-xl p-5 mb-6 shadow-sm">
  <h3 class="text-lg font-semibold mb-3">🛠️ Important Setup Steps</h3>
  <ul class="list-decimal pl-6 space-y-2">
    <li>
      Rename <code>.env.example</code> to <code>.env</code>.
    </li>
    <li>
      Set folder permissions:
      <ul class="list-disc pl-6 mt-1">
        <li><code>storage/</code> and <code>bootstrap/cache/</code> → <strong>775</strong></li>
        <li><code>.env</code> → <strong>664</strong></li>
        <li><code>public/uploads</code> → <strong>775</strong></li>
      </ul>
    </li>
  </ul>
</div>

            <li>Visit your site in the browser (<code>yourdomain.com</code> or <code>http://localhost</code>).</li>
          </ol>



  <div>
    <iframe
      width="560"
      height="315"
      src="https://www.youtube.com/embed/bqPH52a1VXc"
      title="YouTube video player"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen
    ></iframe>
  </div>





        </div>


<div class="divider"></div>
        <!-- Developer Version -->
        <div>
          <h2 class="text-2xl font-semibold text-blue-800 mb-2">💻 2. Developer Version</h2>
          <p class="italic mb-4 text-gray-600">Full Source Code (For Developers & Customization)</p>
          <p class="mb-4 text-gray-700">
            Ideal for developers who want full control over Accessly, including the ability to customize, extend, or integrate it.
          </p>

          <h3 class="text-xl font-semibold text-gray-800 mb-2">🔹 Use Cases</h3>
          <ul class="list-disc pl-6 mb-4 text-gray-700">
            <li>Customizing UI/UX with Tailwind CSS & Vue 3</li>
            <li>Adding new modules or features</li>
            <li>Customizing the existingfeatures</li>
          </ul>

          <h3 class="text-xl font-semibold text-gray-800 mb-2">🧑‍💻 Setup Instructions</h3>
          <ol class="list-decimal pl-6 space-y-2 text-gray-700">
            <li>Unzip the "source-code.zip" file.</li>
            <li>Open the project in your preferred code editor.</li>
            <li>Rename <code>.env.example</code> to <code>.env</code>.</li>
            <li>Set up proper permissions:
              <ul class="list-disc pl-6 mt-1">
                <li><code>storage/</code> and <code>bootstrap/cache/</code> → <strong>775</strong></li>
                <li><code>.env</code> → <strong>664</strong></li>
                <li><code>public/uploads</code> → <strong>775</strong></li>
              </ul>
            </li>
            <li>Run the following in your terminal:
              <ul class="list-disc pl-6 mt-1 text-sm text-gray-600">
                <li><code>composer install --no-dev --optimize-autoloader</code></li>
                <li><code>npm install && npm run dev</code></li>
              </ul>
            </li>
            <li>Launch the app using:
              <ul class="list-disc pl-6 mt-1 text-sm text-gray-600">
                <li><code>php artisan serve</code></li>
              </ul>
            </li>
          </ol>

          <div class="mt-6 text-green-700 font-medium">
            ✅ After completing these steps, your Laravel app is fully configured and ready to use.
          </div>
        </div>
      </section>
    </main>
  </div>
</template>



<script setup>
import Sidebar from '../Components/SideBar.vue'
import { Head } from '@inertiajs/vue3'

</script>
