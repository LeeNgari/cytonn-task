<template>
  <form @submit.prevent="handleLogin" class="space-y-6 p-6 bg-white shadow-lg rounded-xl border border-gray-200">
    <!-- Demo Credentials Box -->
    <div class="p-4 bg-gray-100 rounded-md border border-gray-200 text-sm text-gray-700 space-y-2">
      <p class="font-semibold text-gray-900">Demo Accounts:</p>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <p class="font-medium text-gray-800">Admin Account:</p>
          <p>Email: <span class="font-mono">leengari76@gmail.com</span></p>
          <p>Password: <span class="font-mono">password</span></p>
        </div>
        <div>
          <p class="font-medium text-gray-800">User Account:</p>
          <p>Email: <span class="font-mono">barakalee2002@gmail.com</span></p>
          <p>Password: <span class="font-mono">password</span></p>
        </div>
      </div>
      <p class="pt-2 text-gray-500 text-xs italic">
        Note: First request may take up to 60 seconds due to server warm-up.
      </p>
    </div>

    <!-- Email Field -->
    <div class="space-y-1.5">
      <Label for="email" class="text-sm font-medium text-gray-800">Email</Label>
      <div class="relative">
        <Input
          id="email"
          v-model="email"
          type="email"
          placeholder="you@example.com"
          required
          class="pl-11 pr-4 py-2.5 text-base border border-gray-300 rounded-md bg-white text-black placeholder-gray-400 focus:ring-2 focus:ring-black focus:outline-none"
        />
        <Mail class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500" />
      </div>
    </div>

    <!-- Password Field -->
    <div class="space-y-1.5">
      <Label for="password" class="text-sm font-medium text-gray-800">Password</Label>
      <div class="relative">
        <Input
          id="password"
          v-model="password"
          type="password"
          required
          placeholder="••••••••"
          class="pl-11 pr-4 py-2.5 text-base border border-gray-300 rounded-md bg-white text-black placeholder-gray-400 focus:ring-2 focus:ring-black focus:outline-none"
        />
        <Lock class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500" />
      </div>
    </div>

    <!-- Error Message -->
    <transition name="fade">
      <Alert v-if="error" variant="destructive" class="text-left border border-red-200 bg-red-50 text-red-800">
        <AlertCircle class="h-4 w-4" />
        <div>
          <AlertTitle class="text-base font-semibold">Login failed</AlertTitle>
          <AlertDescription class="text-sm">{{ error }}</AlertDescription>
        </div>
      </Alert>
    </transition>

    <!-- Submit Button -->
    <Button
      type="submit"
      class="w-full gap-2 text-sm py-2.5 bg-black text-white font-semibold tracking-wide transition hover:shadow-md hover:bg-gray-900 rounded-md"
      :disabled="isLoading"
    >
      <Loader2 class="h-4 w-4 animate-spin" v-if="isLoading" />
      <LogIn class="h-4 w-4" v-else />
      Sign In
    </Button>
  </form>
</template>


<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { Mail, Lock, AlertCircle, Loader2, LogIn } from 'lucide-vue-next'

const email = ref('')
const password = ref('')
const error = ref(null)
const isLoading = ref(false)
const authStore = useAuthStore()
const router = useRouter()

const handleLogin = async () => {
  error.value = null
  isLoading.value = true
  try {
    await authStore.login({ email: email.value, password: password.value })
    router.push(authStore.user.role === 'admin' ? '/admin-dashboard' : '/user-dashboard')
  } catch (err) {
    error.value = err.response?.data?.message || 'Invalid credentials'
  } finally {
    isLoading.value = false
  }
}
</script>
