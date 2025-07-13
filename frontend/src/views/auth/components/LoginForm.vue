<template>
  <form @submit.prevent="handleLogin" class="space-y-6">
    <!-- Email Field -->
    <div class="space-y-2">
      <Label for="email" class="text-sm font-medium">Email</Label>
      <div class="relative">
        <Input
          id="email"
          v-model="email"
          type="email"
          placeholder="you@example.com"
          required
          class="pl-10 pr-4 py-2"
        />
        <Mail class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
      </div>
    </div>

    <!-- Password Field -->
    <div class="space-y-2">
      <Label for="password" class="text-sm font-medium">Password</Label>
      <div class="relative">
        <Input
          id="password"
          v-model="password"
          type="password"
          required
          placeholder="••••••••"
          class="pl-10 pr-4 py-2"
        />
        <Lock class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
      </div>
    </div>

    <!-- Error Message -->
    <Alert v-if="error" variant="destructive">
      <AlertCircle class="h-4 w-4" />
      <AlertTitle class="text-base font-semibold">Login failed</AlertTitle>
      <AlertDescription class="text-sm">{{ error }}</AlertDescription>
    </Alert>

    <!-- Login Button -->
    <Button type="submit" class="w-full gap-2 text-sm" :disabled="isLoading">
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
