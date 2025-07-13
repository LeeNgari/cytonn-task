<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-blue-50 px-4">
    <Card class="w-full max-w-sm border border-gray-200 shadow-md rounded-xl bg-white">
      <CardHeader class="space-y-1 pb-2">
        <CardTitle class="text-2xl flex items-center gap-2 text-gray-900">
          <ClipboardList class="h-6 w-6 text-primary" />
          TaskFlow
        </CardTitle>
        <CardDescription class="text-sm text-muted-foreground">
          Sign in to your account to continue
        </CardDescription>
      </CardHeader>
      
      <CardContent>
        <LoginForm />
      </CardContent>
    </Card>
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
