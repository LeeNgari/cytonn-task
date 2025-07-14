<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-blue-50 px-4 py-10">
    <div class="flex flex-col md:flex-row items-center gap-10 w-full max-w-5xl">
      
      <!-- Large Logo -->
      <img
        src="@/assets/logo.png"
        alt="TaskFlow Logo"
        class="w-90 h-50 md:w-52 md:h-52 rounded-xl shadow-xl object-contain transition-transform hover:scale-105"
      />

      <!-- Enlarged Login Card -->
      <Card class="w-full max-w-md md:max-w-xl border border-gray-200 shadow-2xl rounded-2xl bg-white transition-shadow hover:shadow-xl">
        <CardHeader class="space-y-2 pb-4">
          <CardTitle class="text-3xl flex items-center gap-3 text-gray-900">
            <ClipboardList class="h-7 w-7 text-primary" />
            TaskFlow
          </CardTitle>
          <CardDescription class="text-base text-muted-foreground">
            Sign in to your account to continue
          </CardDescription>
        </CardHeader>

        <CardContent class="pt-2">
          <LoginForm />
        </CardContent>
      </Card>
    </div>
  </div>
</template>

<script setup>
import LoginForm from './components/LoginForm.vue'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { ClipboardList } from 'lucide-vue-next'
</script>
