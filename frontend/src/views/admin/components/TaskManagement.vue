<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <CardTitle class="text-xl font-semibold">Task Management</CardTitle>
      <Button @click="showTaskForm = true" class="gap-2">
        <Plus class="h-4 w-4" />
        Add Task
      </Button>
    </div>

    <!-- Task Form Modal -->
    <Dialog v-model:open="showTaskForm">
      <DialogContent class="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle>{{ selectedTask ? 'Edit Task' : 'Create Task' }}</DialogTitle>
        </DialogHeader>
        <TaskForm
          :task="selectedTask"
          @taskCreated="handleTaskCreated"
          @taskUpdated="handleTaskUpdated"
          @close="showTaskForm = false; selectedTask = null"
        />
      </DialogContent>
    </Dialog>

    <!-- Loading State -->
    <div v-if="loadingTasks" class="space-y-4">
      <CardSkeleton v-for="i in 3" :key="`task-skeleton-${i}`" />
    </div>

    <!-- Error State -->
    <Alert variant="destructive" v-if="taskError">
      <AlertCircle class="h-4 w-4" />
      <AlertTitle>Error</AlertTitle>
      <AlertDescription>{{ taskError }}</AlertDescription>
    </Alert>

    <!-- Tasks Table -->
    <div v-else class="border rounded-lg overflow-hidden">
      <Table>
        <TableHeader class="bg-gray-100">
          <TableRow>
            <TableHead>Title</TableHead>
            <TableHead>Assigned To</TableHead>
            <TableHead>Deadline</TableHead>
            <TableHead>Status</TableHead>
            <TableHead class="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow 
            v-for="task in tasks" 
            :key="task.id" 
            class="hover:bg-gray-50"
          >
            <TableCell class="font-medium">{{ task.title }}</TableCell>
            <TableCell>
              <Badge variant="outline">
                {{ task.assigned_user?.name || 'Unassigned' }}
              </Badge>
            </TableCell>
            <TableCell>
              <Badge 
                variant="outline" 
                :class="{
                  'border-red-200 bg-red-50 text-red-600': isOverdue(task.deadline),
                  'border-green-200 bg-green-50 text-green-600': !isOverdue(task.deadline) && isDueSoon(task.deadline)
                }"
              >
                {{ formatDate(task.deadline) }}
              </Badge>
            </TableCell>
            <TableCell>
              <Badge 
                :variant="statusVariant(task.status)"
                class="capitalize"
              >
                {{ formatStatus(task.status) }}
              </Badge>
            </TableCell>
            <TableCell class="flex justify-end gap-2">
              <Button 
                variant="outline" 
                size="sm" 
                @click="editTask(task)"
                class="h-8 gap-1"
              >
                <Pencil class="h-3 w-3" />
                <span class="sr-only sm:not-sr-only">Edit</span>
              </Button>
              <Button 
                variant="outline" 
                size="sm" 
                @click="deleteTask(task.id)"
                class="h-8 gap-1 text-red-600 hover:text-red-600 hover:bg-red-50"
              >
                <Trash2 class="h-3 w-3" />
                <span class="sr-only sm:not-sr-only">Delete</span>
              </Button>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { API_BASE_URL } from '@/config'
import {
  Plus,
  Pencil,
  Trash2,
  AlertCircle,
} from 'lucide-vue-next'
import TaskForm from '@/components/TaskForm.vue'
import CardSkeleton from '@/components/CardSkeleton.vue'

import { Button } from '@/components/ui/button'
import { CardTitle } from '@/components/ui/card'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Badge } from '@/components/ui/badge'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog'

const tasks = ref([])
const loadingTasks = ref(true)
const taskError = ref(null)
const showTaskForm = ref(false)
const selectedTask = ref(null)

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
    const response = await axios.get(`${API_BASE_URL}/tasks`);
    tasks.value = response.data;
  } catch (err) {
    taskError.value = 'Failed to fetch tasks.' + (err.response?.data?.message || err.message);
  } finally {
    loadingTasks.value = false;
  }
};

const editTask = (task) => {
  console.log('Editing task:', task);
  selectedTask.value = { ...task };
  showTaskForm.value = true;
  console.log('showTaskForm after click:', showTaskForm.value);
};

const handleTaskCreated = (newTask) => {
  tasks.value.push(newTask);
  showTaskForm.value = false;
  selectedTask.value = null;
};

const handleTaskUpdated = (updatedTask) => {
  const index = tasks.value.findIndex(task => task.id === updatedTask.id);
  if (index !== -1) {
    tasks.value[index] = updatedTask;
  }
  showTaskForm.value = false;
  selectedTask.value = null;
};

const deleteTask = async (taskId) => {
  if (confirm('Are you sure you want to delete this task?')) {
    try {
      await axios.delete(`${API_BASE_URL}/tasks/${taskId}`);
      tasks.value = tasks.value.filter(task => task.id !== taskId);
    } catch (err) {
      alert('Failed to delete task: ' + (err.response?.data?.message || err.message));
    }
  }
};

onMounted(() => {
  fetchTasks();
});
</script>
