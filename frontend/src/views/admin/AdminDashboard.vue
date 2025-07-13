<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
      <AdminHeader />

      <!-- Main Content -->
      <Card class="overflow-hidden">
        <Tabs v-model="activeTab" class="w-full">
          <TabsList class="w-full rounded-none border-b bg-transparent">
            <TabsTrigger value="users" class="gap-2">
              <Users class="h-4 w-4" />
              Users
            </TabsTrigger>
            <TabsTrigger value="tasks" class="gap-2">
              <ClipboardList class="h-4 w-4" />
              Tasks
            </TabsTrigger>
          </TabsList>

          <!-- Users Tab -->
          <TabsContent value="users" class="p-6">
            <UserManagement />
          </TabsContent>

          <!-- Tasks Tab -->
          <TabsContent value="tasks" class="p-6">
            <TaskManagement />
          </TabsContent>
        </Tabs>
      </Card>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  ClipboardList,
  Users,
} from 'lucide-vue-next'

import AdminHeader from './components/AdminHeader.vue'
import UserManagement from './components/UserManagement.vue'
import TaskManagement from './components/TaskManagement.vue'

import { Card } from '@/components/ui/card'
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'

const activeTab = ref('users')
</script>

<style>
/* Smooth transitions for tabs */
[data-state="active"] {
  transition: all 0.2s ease;
}
</style>
