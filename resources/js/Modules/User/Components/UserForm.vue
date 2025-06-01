<script setup>

import { ref } from 'vue';
const emit = defineEmits();
const props = defineProps({
  user: {
    type: Object,
    default: () => ({}),
  },
  allRoles: {
    type: Array,
    default: () => [],
  },
  permissions: {
    type: Array,
    default: () => [],
  },
  isAdmin:
  {
    Boolean
  },
})


const selectedRoles = ref(
  props.user.roles ? props.user.roles.map(p => p.id) : []
)


const first_name = ref(props.user.first_name);
const last_name = ref(props.user.last_name);
const phone_number = ref(props.user.phone_number);
const profilePicture = ref(null)
const previewUrl = ref(null)
const email = ref(props.user.email);
const password = ref();
const password_confirmation = ref();
// Validation state
const isValid = ref(true);

function handleImageUpload(event) {
  const file = event.target.files[0]
  if (file) {
    profilePicture.value = file
    previewUrl.value = URL.createObjectURL(file)
  }
}

const submitForm = () => {
  if (!first_name.value || !email.value || !last_name.value) {
    isValid.value = false;
    return;
  }

  const payload = {
    first_name: first_name.value,
    last_name: last_name.value,
    phone_number: phone_number.value,
    email: email.value,
    roles: selectedRoles.value,
    profile_picture: profilePicture.value
  };

  // Include password fields only if filled
  if (password.value) {
    payload.password = password.value;
    payload.password_confirmation = password_confirmation.value;
  }

  emit('submit-user', payload);

};


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
  <div class="card bg-base-100 shadow-md p-8 space-y-8">
    <form @submit.prevent="submitForm" class="space-y-6">
      
      <!-- Profile Picture Upload -->
      <div class="form-control">
        <!-- Logo Preview -->
        <div v-if="user.profile_picture" class="flex flex-col items-center mb-4">
          <img :src="resolveImage(user.profile_picture)" alt="Profile" class="w-24 h-24 rounded-full mt-2" />
        </div>

        <div v-if="previewUrl" class="mb-4">
          <img
            :src="previewUrl"
            alt="New image"
            class="w-24 h-24 rounded-full"
          />
        </div>

        <!-- File input -->
        <input
          type="file"
          id="profile_picture"
          accept="image/*"
          @change="handleImageUpload"
         class="file-input file-input-info"
        />
      </div>



      <!-- User Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-control">
          <label for="first_name" class="label">
            <span class="label-text">First Name</span>
          </label>
          <input
            type="text"
            id="first_name"
            v-model="first_name"
            required
            class="input input-bordered"
            :class="{ 'input-error': !isValid }"
          />
        </div>

        <div class="form-control">
          <label for="last_name" class="label">
            <span class="label-text">Last Name</span>
          </label>
          <input
            type="text"
            id="last_name"
            v-model="last_name"
            required
            class="input input-bordered"
            :class="{ 'input-error': !isValid }"
          />
        </div>

        <div class="form-control">
          <label for="email" class="label">
            <span class="label-text">Email</span>
          </label>
          <input
            type="email"
            id="email"
            v-model="email"
            required
            class="input input-bordered"
            :class="{ 'input-error': !isValid }"
          />
        </div>

        <div class="form-control">
          <label for="phone" class="label">
            <span class="label-text">Phone Number</span>
          </label>
          <input
            type="text"
            id="phone"
            v-model="phone_number"
            class="input input-bordered"
          />
        </div>
      </div>

      <!-- Passwords -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-control">
          <label for="password" class="label">
            <span class="label-text">Password</span>
          </label>
          <input
            type="password"
            autocomplete="new-password"
            id="password"
            v-model="password"
            class="input input-bordered"
            :class="{ 'input-error': !isValid }"
          />
        </div>

        <div class="form-control">
          <label for="password_confirmation" class="label">
            <span class="label-text">Confirm Password</span>
          </label>
          <input
            type="password"
            id="password_confirmation"
            v-model="password_confirmation"
            class="input input-bordered"
            :class="{ 'input-error': !isValid }"
          />
        </div>
      </div>

      <!-- Roles -->
      <div v-if="!isAdmin" class="space-y-2">
        <h3 class="text-lg font-bold">Assign Roles</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div v-for="role in props.allRoles" :key="role.id" class="form-control">
            <label class="cursor-pointer label gap-2">
              <input
                type="checkbox"
                :value="role.id"
                v-model="selectedRoles"
                class="checkbox checkbox-info text-white"
              />
              <span class="label-text">{{ role.name }}</span>
            </label>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-control mt-6">
        <button type="submit" class="btn btn-info w-full text-white">
          Save User
        </button>
      </div>

    </form>

    <!-- General validation error -->
    <div v-if="!isValid" class="alert alert-error mt-4">
      Please fill in all required fields correctly.
    </div>

    <!-- Permissions -->
  <!-- Permissions Section -->
  <div v-if="permissions.length > 0" class="space-y-4">
    <!-- Permissions Badges -->
    <p class="font-semibold">Assigned Permissions</p>
    <div class="flex flex-wrap gap-2">
      <span
        v-for="(permission, index) in permissions"
        :key="permission.id"
        class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"
      >
        {{ permission.name }}
        <span v-if="index < permissions.length - 1"></span>
      </span>
    </div>
  </div>
  <!-- No Permissions Message -->
  <div v-else class="text-gray-400 italic text-lg">
    No permissions assigned.
  </div>

  </div>


</template>

<style scoped>
/* Form input & button styles */
input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
  width: 100%;
  border-radius: 0.375rem;
  border: 1px solid #ddd;
  transition: border-color 0.3s ease;
}

input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="file"]:focus {
  border-color: #a19cff; /* Blue focus */
  outline: none;
}

/* Submit Button Styling */
button {
  font-weight: bold;
  transition: background-color 0.3s;
}

button:disabled {
  cursor: not-allowed;
}

/* Error styling */
.input-error {
  border-color: #f87171; /* Red */
}

.alert-error {
  background-color: #f87171;
  color: white;
}









/* Styling for the Permissions Table */
table {
  width: 100%;
  border-collapse: collapse;
}

td {
  padding: 1rem;
  text-align: left;
}

.text-sm {
  font-size: 0.875rem; /* Smaller font size */
}

.text-gray-700 {
  color: #2d3748; /* Darker gray */
}

.text-gray-400 {
  color: #cbd5e0;
}

.italic {
  font-style: italic;
}

.hover\:bg-gray-50:hover {
  background-color: #f9fafb;
}

.border-b {
  border-bottom-width: 1px;
  border-color: #e5e7eb;
}









</style>


