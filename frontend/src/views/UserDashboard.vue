<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <Card class="mb-6 border-none shadow-sm bg-gradient-to-r from-blue-600 to-indigo-600">
        <CardHeader class="flex flex-row items-center justify-between">
          <div class="flex items-center gap-3">
            <ClipboardList class="h-8 w-8 text-white" />
            <CardTitle class="text-2xl font-bold text-white">My Tasks</CardTitle>
          </div>
          <Button 
            @click="logout" 
            variant="ghost" 
            class="text-white hover:bg-white/10 gap-2"
          >
            <LogOut class="h-4 w-4" />
            Logout
          </Button>
        </CardHeader>
      </Card>

      <!-- Main Content -->
      <Card>
        <CardHeader>
          <CardTitle class="text-xl">Task Overview</CardTitle>
          <CardDescription>View and manage your assigned tasks</CardDescription>
        </CardHeader>
        
        <CardContent>
          <!-- Loading State -->
          <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <CardSkeleton v-for="i in 3" :key="`skeleton-${i}`" type="task" />
          </div>

          <!-- Error State -->
          <Alert v-else-if="error" variant="destructive">
            <AlertCircle class="h-4 w-4" />
            <AlertTitle>Error</AlertTitle>
            <AlertDescription>{{ error }}</AlertDescription>
          </Alert>

          <!-- Empty State -->
          <div v-else-if="tasks.length === 0" class="flex flex-col items-center justify-center py-12 text-center">
            <ClipboardX class="h-12 w-12 text-gray-400 mb-4" />
            <h3 class="text-lg font-medium text-gray-900">No tasks assigned</h3>
            <p class="text-sm text-gray-500 mt-1">You currently don't have any tasks assigned to you.</p>
          </div>

          <!-- Task Grid -->
          <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <Card 
              v-for="task in tasks" 
              :key="task.id"
              class="hover:shadow-md transition-shadow"
              :class="{
                'border-l-4 border-yellow-500': task.status === 'pending',
                'border-l-4 border-blue-500': task.status === 'in_progress',
                'border-l-4 border-green-500': task.status === 'completed',
              }"
            >
              <CardHeader>
                <div class="flex justify-between items-start">
                  <CardTitle class="text-lg">{{ task.title }}</CardTitle>
                  <Badge :variant="statusVariant(task.status)" class="capitalize">
                    {{ formatStatus(task.status) }}
                  </Badge>
                </div>
                <CardDescription>{{ task.description }}</CardDescription>
              </CardHeader>
              
              <CardContent class="space-y-3">
                <div class="flex items-center gap-2 text-sm">
                  <User class="h-4 w-4 text-gray-500" />
                  <span class="text-gray-600">
                    {{ task.assigned_user?.name || 'Unassigned' }}
                  </span>
                </div>
                
                <div class="flex items-center gap-2 text-sm">
                  <Calendar class="h-4 w-4 text-gray-500" />
                  <span 
                    class="text-gray-600"
                    :class="{
                      'text-red-600 font-medium': isOverdue(task.deadline),
                      'text-green-600 font-medium': !isOverdue(task.deadline) && isDueSoon(task.deadline)
                    }"
                  >
                    {{ formatDate(task.deadline) }}
                  </span>
                </div>
              </CardContent>
              
              <CardFooter class="flex justify-between items-center">
                <Select 
                  v-model="task.status"
                  @update:modelValue="updateTaskStatus(task.id, task.status)"
                >
                  <SelectTrigger class="h-8">
                    <SelectValue placeholder="Select status" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="pending">
                        <div class="flex items-center gap-2">
                          <Circle class="h-3 w-3 text-yellow-500" />
                          <span>Pending</span>
                        </div>
                      </SelectItem>
                      <SelectItem value="in_progress">
                        <div class="flex items-center gap-2">
                          <Loader2 class="h-3 w-3 text-blue-500 animate-spin" />
                          <span>In Progress</span>
                        </div>
                      </SelectItem>
                      <SelectItem value="completed">
                        <div class="flex items-center gap-2">
                          <CheckCircle2 class="h-3 w-3 text-green-500" />
                          <span>Completed</span>
                        </div>
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                
                <Button 
                  variant="ghost" 
                  size="sm" 
                  @click="viewTaskDetails(task)"
                  class="text-gray-600 hover:text-primary"
                >
                  <Eye class="h-4 w-4" />
                </Button>
              </CardFooter>
            </Card>
          </div>
        </CardContent>
      </Card>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import axios from 'axios'
import { API_BASE_URL } from '../config'
import {
  ClipboardList,
  LogOut,
  ClipboardX,
  User,
  Calendar,
  Circle,
  Loader2,
  CheckCircle2,
  Eye,
  AlertCircle
} from 'lucide-vue-next'

// Import shadcn components
import { Button } from '@/components/ui/button'
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import CardSkeleton from '@/components/CardSkeleton.vue'

const tasks = ref([])
const loading = ref(true)
const error = ref(null)
const authStore = useAuthStore()
const router = useRouter()

// Helper functions
const formatDate = (dateString) => new Date(dateString).toLocaleDateString()
const formatStatus = (status) => status.replace('_', ' ')
const isOverdue = (deadline) => new Date(deadline) < new Date()
const isDueSoon = (deadline) => {
  const dueDate = new Date(deadline)
  const today = new Date()
  const diffTime = dueDate - today
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  return diffDays <= 3 && diffDays >= 0
}

const statusVariant = (status) => {
  switch(status) {
    case 'completed': return 'success'
    case 'in_progress': return 'warning'
    case 'pending': return 'destructive'
    default: return 'outline'
  }
}

const fetchTasks = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/tasks`)
    tasks.value = response.data
  } catch (err) {
    error.value = 'Failed to fetch tasks: ' + (err.response?.data?.message || err.message)
  } finally {
    loading.value = false
  }
}

const updateTaskStatus = async (taskId, newStatus) => {
  try {
    await axios.patch(`${API_BASE_URL}/tasks/${taskId}/status`, { status: newStatus })
    // Optional: Show toast notification
  } catch (err) {
    error.value = 'Failed to update task status: ' + (err.response?.data?.message || err.message)
    fetchTasks() // Revert by refetching
  }
}

const viewTaskDetails = (task) => {
  // Implement task detail view logic
  console.log('View task:', task)
}

const logout = async () => {
  await authStore.logout()
  router.push('/login')
}

onMounted(() => {
  fetchTasks()
})
</script>

<style scoped>
/* Custom transitions */
.hover\:shadow-md {
  transition: box-shadow 0.2s ease;
}
</style>