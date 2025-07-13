<template>
  <div class="min-h-screen flex items-center justify-center bg-[#fafafa] px-4">
    <Card class="w-full max-w-sm shadow-sm border-border">
      <CardHeader class="space-y-1">
        <CardTitle class="text-2xl flex items-center gap-2">
          <ClipboardList class="h-6 w-6 text-primary" />

          TaskFlow
        </CardTitle>
        <CardDescription>
          Sign in to your account
        </CardDescription>
      </CardHeader>
      
      <CardContent>
        <form @submit.prevent="handleLogin" class="space-y-4">
          <div class="space-y-2">
            <Label for="email">Email</Label>
            <div class="relative">
              <Input
                id="email"
                v-model="email"
                type="email"
                placeholder="you@example.com"
                required
                class="pl-9"
              />
              <Mail class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
            </div>
          </div>
          
          <div class="space-y-2">
            <Label for="password">Password</Label>
            <div class="relative">
              <Input
                id="password"
                v-model="password"
                type="password"
                required
                placeholder="••••••••"
                class="pl-9"
              />
              <Lock class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
            </div>
          </div>
          
          <Alert variant="destructive" v-if="error">
            <AlertCircle class="h-4 w-4" />
            <AlertTitle>Login failed</AlertTitle>
            <AlertDescription>{{ error }}</AlertDescription>
          </Alert>
          
          <Button type="submit" class="w-full gap-2" :disabled="isLoading">
            <Loader2 class="h-4 w-4 animate-spin" v-if="isLoading" />
            <LogIn class="h-4 w-4" v-else />
            Sign In
          </Button>
        </form>
      </CardContent>
    </Card>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { ClipboardList, Mail, Lock, AlertCircle, Loader2, LogIn } from 'lucide-vue-next'

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
    await authStore.login({ 
      email: email.value, 
      password: password.value 
    })
    
    if (authStore.user.role === 'admin') {
      router.push('/admin-dashboard')
    } else {
      router.push('/user-dashboard')
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Invalid credentials'
  } finally {
    isLoading.value = false
  }
}
</script>