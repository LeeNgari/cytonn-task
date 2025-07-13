<template>
  <Card>
    <CardHeader>
      <CardTitle class="text-xl">Task Overview</CardTitle>
      <CardDescription>View and manage your assigned tasks</CardDescription>
    </CardHeader>

    <CardContent>
      <!-- Loading -->
      <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <CardSkeleton v-for="i in 3" :key="`skeleton-${i}`" type="task" />
      </div>

      <!-- Error -->
      <Alert v-else-if="error" variant="destructive">
        <AlertCircle class="h-4 w-4" />
        <AlertTitle>Error</AlertTitle>
        <AlertDescription>{{ error }}</AlertDescription>
      </Alert>

      <!-- Empty -->
      <div v-else-if="tasks.length === 0" class="flex flex-col items-center justify-center py-12 text-center">
        <ClipboardX class="h-12 w-12 text-gray-400 mb-4" />
        <h3 class="text-lg font-medium text-gray-900">No tasks assigned</h3>
        <p class="text-sm text-gray-500 mt-1">You currently don't have any tasks assigned to you.</p>
      </div>

      <!-- Task Cards -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <Card
          v-for="task in tasks"
          :key="task.id"
          @click="toggleExpanded(task.id)"
          class="hover:shadow-md transition-shadow cursor-pointer"
          :class="{
            'border-l-4 border-yellow-500': task.status === 'pending',
            'border-l-4 border-blue-500': task.status === 'in_progress',
            'border-l-4 border-green-500': task.status === 'completed',
          }"
        >
          <CardHeader>
            <div class="flex justify-between items-start">
              <CardTitle class="text-base">{{ task.title }}</CardTitle>
              <Badge :variant="statusVariant(task.status)" class="capitalize">
                {{ formatStatus(task.status) }}
              </Badge>
            </div>
            <CardDescription class="text-xs">Task ID: {{ task.id }}</CardDescription>
          </CardHeader>

          <CardContent class="space-y-2 text-sm">
            <div class="flex items-center gap-2">
              <Calendar class="h-4 w-4 text-gray-500" />
              <span :class="{
                'text-red-600 font-medium': isOverdue(task.deadline),
                'text-green-600 font-medium': !isOverdue(task.deadline) && isDueSoon(task.deadline)
              }">
                {{ formatDate(task.deadline) }}
              </span>
            </div>

            <Transition name="fade">
              <div v-if="expandedTaskId === task.id" class="mt-2 space-y-1">
                <p class="text-gray-700"><strong>Description:</strong> {{ task.description }}</p>
                <p class="text-gray-700"><strong>Assigned To:</strong> {{ task.assigned_user?.name || 'Unassigned' }}</p>
                <p class="text-gray-500 text-xs">Created: {{ formatDate(task.created_at) }}</p>
                <p class="text-gray-500 text-xs">Updated: {{ formatDate(task.updated_at) }}</p>
              </div>
            </Transition>
          </CardContent>

          <CardFooter class="flex justify-between items-center">
            <Select 
              v-model="task.status"
              @update:modelValue="updateTaskStatus(task)"
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
            <Button variant="ghost" size="sm" class="cursor-pointer text-gray-600 hover:text-primary">
              <Eye class="h-4 w-4" />
            </Button>
          </CardFooter>
        </Card>
      </div>
    </CardContent>
  </Card>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { API_BASE_URL } from '@/config'
import {
  ClipboardX,
  User,
  Calendar,
  Circle,
  Loader2,
  CheckCircle2,
  Eye,
  AlertCircle
} from 'lucide-vue-next'

import {
  Card,
  CardHeader,
  CardTitle,
  CardDescription,
  CardContent,
  CardFooter
} from '@/components/ui/card'

import { Badge } from '@/components/ui/badge'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue
} from '@/components/ui/select'

import { Button } from '@/components/ui/button'
import CardSkeleton from '@/components/CardSkeleton.vue'

const tasks = ref([])
const loading = ref(true)
const error = ref(null)
const expandedTaskId = ref(null)



const formatDate = (dateStr) => new Date(dateStr).toLocaleDateString()
const formatStatus = (s) => s.replace('_', ' ')
const isOverdue = (d) => new Date(d) < new Date()
const isDueSoon = (d) => {
  const diff = new Date(d) - new Date()
  return diff > 0 && diff / (1000 * 60 * 60 * 24) <= 3
}
const statusVariant = (s) => ({
  completed: 'success',
  in_progress: 'warning',
  pending: 'destructive'
}[s] || 'outline')

const toggleExpanded = (id) => {
  expandedTaskId.value = expandedTaskId.value === id ? null : id
}

const fetchTasks = async () => {
  try {
    const res = await axios.get(`${API_BASE_URL}/tasks`)
    tasks.value = res.data
  } catch (err) {
    error.value = 'Failed to fetch tasks: ' + (err.response?.data?.message || err.message)
  } finally {
    loading.value = false
  }
}

const updateTaskStatus = async (task) => {
  try {
    await axios.patch(`${API_BASE_URL}/tasks/${task.id}/status`, { status: task.status })
    
  } catch (err) {
    error.value = 'Failed to update status: ' + (err.response?.data?.message || err.message)
    fetchTasks() // revert
  }
}

onMounted(fetchTasks)
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: all 0.2s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: scale(0.98);
}
</style>
