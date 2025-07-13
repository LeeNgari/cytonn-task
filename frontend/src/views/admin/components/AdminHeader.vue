<template>
  <Card class="mb-6 border-b shadow-sm ">
    <CardHeader class="flex flex-row items-center justify-between">
      <div class="flex items-center gap-3">
        <ClipboardList class="h-8 w-8 " />
        <CardTitle class="text-2xl font-bold ">TaskFlow Admin</CardTitle>
      </div>
      <Button 
        @click="logout" 
        variant="ghost" 
        class="cursor-pointer hover:bg-blue-100 gap-2"
      >
        <LogOut class="h-4 w-4 " />
        Logout
      </Button>
    </CardHeader>
  </Card>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import {
  ClipboardList,
  LogOut,
} from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Card, CardHeader, CardTitle } from '@/components/ui/card'

const authStore = useAuthStore()
const router = useRouter()

const logout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>
