<script setup>

defineProps({
    user: Object,

})

function resolveImage(path) {
  if (!path || path === 'null') return '/uploads/profile_pictures/avatar.jpg';

  if (path.includes('/storage/')) {
    path = path.replace('/storage/', '/uploads/');
  }

  if (path.startsWith('http') || path.startsWith('/uploads')) {
    return path;
  }

  return `/${path.replace(/^\/+/, '')}`;
}


</script>


<template>

 
              <!-- Online Status -->
              <div class="flex items-center gap-2 mb-4">
                <!-- Online Status (Green) -->
                <span v-if="user.is_online" class="text-success text-2xl">
                  🟢
                </span>
                
                <!-- Offline Status (Gray) -->
                <span v-else class="text-gray-500 text-2xl">
                  ⚪
                </span>
                
                <span class="font-bold text-sm">User Status</span>
              </div>



                <!-- User Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <p><strong>First Name:</strong> {{ user.first_name }}</p>
                    <p><strong>Last Name:</strong> {{ user.last_name }}</p>
                    <p><strong>Email:</strong> {{ user.email }}</p>
                    <p><strong>Phone Number:</strong> {{ user.phone_number }}</p>
                  </div>
                  <div class="flex flex-col items-center">
                    <strong>Profile Picture:</strong>
                    <div v-if="user.profile_picture" class="flex flex-col items-center">
                    <img :src="resolveImage(user.profile_picture)" alt="Profile" class="w-24 h-24  rounded-full mt-2" />
                  </div>                  
                  </div>



</div>
</template>