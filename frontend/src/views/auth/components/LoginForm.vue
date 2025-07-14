<template>
  <form @submit.prevent="handleLogin" class="space-y-6">
    <!-- Email Field -->
    <div class="space-y-1.5">
      <Label for="email" class="text-sm font-medium text-gray-700">Email</Label>
      <div class="relative">
        <Input
          id="email"
          v-model="email"
          type="email"
          placeholder="you@example.com"
          required
          class="pl-11 pr-4 py-2.5 text-base border rounded-md transition focus:ring-2 focus:ring-primary focus:outline-none"
        />
        <Mail class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
      </div>
    </div>

    <!-- Password Field -->
    <div class="space-y-1.5">
      <Label for="password" class="text-sm font-medium text-gray-700">Password</Label>
      <div class="relative">
        <Input
          id="password"
          v-model="password"
          type="password"
          required
          placeholder="••••••••"
          class="pl-11 pr-4 py-2.5 text-base border rounded-md transition focus:ring-2 focus:ring-primary focus:outline-none"
        />
        <Lock class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
      </div>
    </div>

    <!-- Error Message -->
    <transition name="fade">
      <Alert v-if="error" variant="destructive" class="text-left">
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
      class="w-full gap-2 text-sm py-2.5 text-white font-semibold tracking-wide transition hover:shadow-md hover:bg-primary/90"
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
