<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">User Dashboard</h1>
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">My Tasks</h2>
        <Button
          @click="logout"
          variant="destructive"
        >
          Logout
        </Button>
      </div>

      <div v-if="loading" class="text-center text-gray-600">Loading tasks...</div>
      <div v-else-if="error" class="text-center text-red-500">{{ error }}</div>
      <div v-else-if="tasks.length === 0" class="text-center text-gray-600">No tasks assigned to you.</div>
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <Card v-for="task in tasks" :key="task.id">
          <CardHeader>
            <CardTitle>{{ task.title }}</CardTitle>
            <CardDescription>{{ task.description }}</CardDescription>
          </CardHeader>
          <div class="text-sm text-gray-600 mb-2">
            <span class="font-semibold">Assigned To:</span> {{ task.assigned_to_user?.name || 'N/A' }}
          </div>
          <div class="text-sm text-gray-600 mb-4">
            <span class="font-semibold">Deadline:</span> {{ new Date(task.deadline).toLocaleDateString() }}
          </div>
          <div class="flex items-center justify-between">
            <div class="text-sm">
              <span class="font-semibold">Status:</span>
              <span
                :class="{
                  'text-yellow-600': task.status === 'pending',
                  'text-blue-600': task.status === 'in_progress',
                  'text-green-600': task.status === 'completed',
                }"
                class="capitalize"
              >
                {{ task.status.replace('_', ' ') }}
              </span>
            </div>
            <select
              v-model="task.status"
              @change="updateTaskStatus(task.id, task.status)"
              class="px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm"
            >
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
          </div>
        </Card>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { API_BASE_URL } from '../config';
import { Button } from '../components/ui/button';
import { Card, CardHeader, CardTitle, CardDescription } from '../components/ui/card';

const tasks = ref([]);
const loading = ref(true);
const error = ref(null);
const authStore = useAuthStore();
const router = useRouter();

const fetchTasks = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/tasks`);
    tasks.value = response.data;
  } catch (err) {
    error.value = 'Failed to fetch tasks.' + (err.response?.data?.message || err.message);
  } finally {
    loading.value = false;
  }
};

const updateTaskStatus = async (taskId, newStatus) => {
  try {
    await axios.patch(`${API_BASE_URL}/tasks/${taskId}/status`, { status: newStatus });
    // Optionally, re-fetch tasks or update the specific task in the array
    // For simplicity, we'll just assume success and the UI already reflects the change
  } catch (err) {
    alert('Failed to update task status: ' + (err.response?.data?.message || err.message));
    // Revert status in UI if update fails
    fetchTasks();
  }
};

const logout = async () => {
  await authStore.logout();
  router.push('/login');
};

onMounted(() => {
  fetchTasks();
});
</script>

<style scoped>
/* Add any component-specific styles here if needed */
</style>
