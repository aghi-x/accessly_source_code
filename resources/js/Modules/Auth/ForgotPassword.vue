<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';

import InputError from '@/Components/Auth/InputError.vue';
import InputLabel from '@/Components/Auth/InputLabel.vue';
import SecondaryButton from '@/Components/Auth/SecondaryButton.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>

    <div class="bg-[url('/storage/images/Background.png')]  flex items-center justify-center h-screen 
           bg-gradient-radial from-sky-400 via-blue-300 to-emerald-200 
            bg-cover bg-no-repeat bg-center">
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit">
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

            <div class="mt-4 flex items-center justify-end">
                <SecondaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                </SecondaryButton>
            </div>
        </form>
    </GuestLayout>
</div>


</template>
