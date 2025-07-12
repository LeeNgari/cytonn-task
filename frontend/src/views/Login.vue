<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-bold text-center text-gray-900">Login</h2>
      <form @submit.prevent="handleLogin" class="space-y-4">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            type="email"
            id="email"
            v-model="email"
            required
            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            type="password"
            id="password"
            v-model="password"
            required
            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
        <div>
          <Button type="submit" class="w-full">
            Login
          </Button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { Button } from '../components/ui/button';

const email = ref('');
const password = ref('');
const error = ref(null);
const authStore = useAuthStore();
const router = useRouter();

const handleLogin = async () => {
  error.value = null;
  try {
    const response = await authStore.login({ email: email.value, password: password.value });
    if (authStore.user.role === 'admin') {
      router.push('/admin-dashboard');
    } else {
      router.push('/user-dashboard');
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Login failed. Please check your credentials.';
  }
};
</script>

<style scoped>
/* Add any component-specific styles here if needed */
</style>
