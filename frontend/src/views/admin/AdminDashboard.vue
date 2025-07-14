<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
      <AdminHeader />
      <!-- Main Content -->
      <Card class="overflow-hidden shadow-lg">
        <Tabs v-model="activeTab" class="w-full">
          <!-- Enhanced TabsList with better styling -->
          <TabsList class="w-full h-15 rounded-none border-b-2 border-gray-100 bg-white/80 backdrop-blur-sm p-1">
            <TabsTrigger 
              value="users" 
              class="group relative gap-2 px-6 py-3 rounded-lg transition-all duration-200 ease-in-out
                    data-[state=active]:text-black data-[state=active]:shadow-md
                     data-[state=inactive]:text-gray-600 data-[state=inactive]:hover:bg-blue-50 data-[state=inactive]:hover:text-blue-600
                     font-medium text-sm"
            >
              <!-- Active indicator bar -->
              <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-black transform scale-x-0 
                          group-data-[state=active]:scale-x-100 transition-transform duration-200"></div>
              
              <Users class="h-4 w-4 transition-transform duration-200 group-data-[state=active]:scale-110" />
              <span class="relative">Users</span>
              
             
            </TabsTrigger>
            
            <TabsTrigger 
              value="tasks" 
              class="group relative gap-2 px-6 py-3 rounded-lg transition-all duration-200 ease-in-out
                      data-[state=active]:text-black data-[state=active]:shadow-md
                     data-[state=inactive]:text-gray-600 data-[state=inactive]:hover:bg-blue-50 data-[state=inactive]:hover:text-blue-600
                     font-medium text-sm"
            >
              <!-- Active indicator bar -->
              <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-black transform scale-x-0 
                          group-data-[state=active]:scale-x-100 transition-transform duration-200"></div>
              
              <ClipboardList class="h-4 w-4 transition-transform duration-200 group-data-[state=active]:scale-110" />
              <span class="relative">Tasks</span>
              
             
            </TabsTrigger>
          </TabsList>
          
          <!-- Users Tab with enhanced styling -->
          <TabsContent value="users" class="p-6 animate-in fade-in-50 duration-200">
            <UserManagement />
          </TabsContent>
          
          <!-- Tasks Tab with enhanced styling -->
          <TabsContent value="tasks" class="p-6 animate-in fade-in-50 duration-200">
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
