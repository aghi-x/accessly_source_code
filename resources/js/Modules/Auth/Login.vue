<script setup>
import Checkbox from '@/Components/Auth/Checkbox.vue';
import InputError from '@/Components/Auth/InputError.vue';
import InputLabel from '@/Components/Auth/InputLabel.vue';
import PrimaryButton from '@/Components/Auth/PrimaryButton.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'

const store = useStore()

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onSuccess: (page) => {
            const user = page.props.auth.user

            store.commit('userProfile/setUserProfile', {
              first_name: user.first_name,
              last_name: user.last_name,
              profile_picture: user.profile_picture, // should be a path or filename
            })

            // Save to localStorage too
            localStorage.setItem('first_name', user.first_name)
            localStorage.setItem('last_name', user.last_name)
            localStorage.setItem('profile_picture', user.profile_picture)



        },
        onError: (errors) => {
           // console.log('Server response (error):', errors);
        },
        onFinish: () => form.reset('password'),
    });
};
</script>






<template>
  <div
    class="bg-[url('/uploads/images/Background.png')]  flex items-center justify-center h-screen 
           bg-gradient-radial from-sky-400 via-blue-300 to-emerald-200 
            bg-cover bg-no-repeat bg-center"
  >


  <Head title="Login" />

    <!-- Login Card -->
    <div class="w-full max-w-md bg-white bg-opacity-90 p-10 rounded-2xl shadow-xl mx-4">

      <!-- Logo & Intro -->
      <div class="mb-8 text-center">
        <!-- Logo Container -->
        <div class="flex justify-center mb-4">
          <div class="bg-[#001b46] p-2 rounded-full shadow-lg">
            <img 
              :src="`/uploads/logos/logo.png`" 
              alt="EfficSoft Logo" 
              class="w-20 h-20 object-cover rounded-full border-4 border-white"
            />
          </div>
        </div>

        <!-- Title & Subtitle -->
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight mb-1">Accessly</h1>
        <p class="text-sm text-gray-600">
          Secure access to 
          <span class="font-medium text-blue-700">roles</span> & 
          <span class="font-medium text-green-700">permissions</span>
        </p>
      </div>

      <!-- Login Form -->
      <form @submit.prevent="submit" class="space-y-6">
        
        <!-- Email -->
        <div>
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <!-- Password -->
        <div>
          <InputLabel for="password" value="Password" />
          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="current-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="text-sm text-gray-600 underline hover:text-gray-900 transition"
          >
            Forgot your password?
          </Link>
        </div>

        <!-- Submit Button -->
        <PrimaryButton
          class="w-full py-2 text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 border-0 shadow-md transition"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Login
        </PrimaryButton>
      </form>
    </div>

  </div>
</template>

