<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <Card class="mb-6 border-none shadow-sm bg-gradient-to-r from-blue-600 to-indigo-600">
        <CardHeader class="flex flex-row items-center justify-between">
          <div class="flex items-center gap-3">
            <ClipboardList class="h-8 w-8 text-white" />
            <CardTitle class="text-2xl font-bold text-white">TaskFlow Admin</CardTitle>
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
            <div class="flex justify-between items-center mb-6">
              <CardTitle class="text-xl font-semibold">User Management</CardTitle>
              <Button @click="showUserForm = true" class="gap-2">
                <Plus class="h-4 w-4" />
                Add User
              </Button>
            </div>

            <!-- User Form Modal -->
            <Dialog v-model:open="showUserForm">
              <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                  <DialogTitle>{{ selectedUser ? 'Edit User' : 'Create User' }}</DialogTitle>
                </DialogHeader>
                <UserForm
                  :user="selectedUser"
                  @userCreated="handleUserCreated"
                  @userUpdated="handleUserUpdated"
                  @close="showUserForm = false; selectedUser = null"
                />
              </DialogContent>
            </Dialog>

            <!-- Loading State -->
            <div v-if="loadingUsers" class="space-y-4">
              <CardSkeleton v-for="i in 3" :key="`user-skeleton-${i}`" />
            </div>

            <!-- Error State -->
            <Alert variant="destructive" v-if="userError">
              <AlertCircle class="h-4 w-4" />
              <AlertTitle>Error</AlertTitle>
              <AlertDescription>{{ userError }}</AlertDescription>
            </Alert>

            <!-- Users Table -->
            <div v-else class="border rounded-lg overflow-hidden">
              <Table>
                <TableHeader class="bg-gray-100">
                  <TableRow>
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Role</TableHead>
                    <TableHead class="text-right">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  <TableRow v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                    <TableCell class="font-medium">{{ user.name }}</TableCell>
                    <TableCell>{{ user.email }}</TableCell>
                    <TableCell>
                      <Badge :variant="user.role === 'admin' ? 'default' : 'secondary'">
                        {{ capitalize(user.role) }}
                      </Badge>
                    </TableCell>
                    <TableCell class="flex justify-end gap-2">
                      <Button 
                        variant="outline" 
                        size="sm" 
                        @click="editUser(user)"
                        class="h-8 gap-1"
                      >
                        <Pencil class="h-3 w-3" />
                        <span class="sr-only sm:not-sr-only">Edit</span>
                      </Button>
                      <Button 
                        variant="outline" 
                        size="sm" 
                        @click="deleteUser(user.id)"
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
          </TabsContent>

          <!-- Tasks Tab -->
          <TabsContent value="tasks" class="p-6">
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
          </TabsContent>
        </Tabs>
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
  Users,
  Plus,
  Pencil,
  Trash2,
  AlertCircle,
} from 'lucide-vue-next'
import UserForm from '../components/UserForm.vue'
import TaskForm from '../components/TaskForm.vue'
import CardSkeleton from '../components/CardSkeleton.vue'

// Import all shadcn components
import { Button } from '@/components/ui/button'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Badge } from '@/components/ui/badge'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog'

const activeTab = ref('users')
const users = ref([])
const tasks = ref([])
const loadingUsers = ref(true)
const loadingTasks = ref(true)
const userError = ref(null)
const taskError = ref(null)
const showUserForm = ref(false)
const selectedUser = ref(null)
const showTaskForm = ref(false)
const selectedTask = ref(null)
const authStore = useAuthStore()
const router = useRouter()

// Helper functions
const capitalize = (str) => str.charAt(0).toUpperCase() + str.slice(1)
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

const fetchUsers = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/users`);
    users.value = response.data;
  } catch (err) {
    userError.value = 'Failed to fetch users.' + (err.response?.data?.message || err.message);
  } finally {
    loadingUsers.value = false;
  }
};

const fetchTasks = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/tasks`);
    tasks.value = response.data;
    console.log(tasks.value)
  } catch (err) {
    taskError.value = 'Failed to fetch tasks.' + (err.response?.data?.message || err.message);
  } finally {
    loadingTasks.value = false;
  }
};

const editUser = (user) => {
  selectedUser.value = { ...user };
  showUserForm.value = true;
};

const deleteUser = async (userId) => {
  if (confirm('Are you sure you want to delete this user?')) {
    try {
      await axios.delete(`${API_BASE_URL}/users/${userId}`);
      users.value = users.value.filter(user => user.id !== userId);
    } catch (err) {
      alert('Failed to delete user: ' + (err.response?.data?.message || err.message));
    }
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

const handleUserCreated = (newUser) => {
  users.value.push(newUser);
  showUserForm.value = false;
  selectedUser.value = null;
};

const handleUserUpdated = (updatedUser) => {
  const index = users.value.findIndex(user => user.id === updatedUser.id);
  if (index !== -1) {
    users.value[index] = updatedUser;
  }
  showUserForm.value = false;
  selectedUser.value = null;
};

const logout = async () => {
  await authStore.logout();
  router.push('/login');
};



onMounted(() => {
  fetchUsers();
  fetchTasks();
});

</script>

<style>
/* Smooth transitions for tabs */
[data-state="active"] {
  transition: all 0.2s ease;
}
</style>