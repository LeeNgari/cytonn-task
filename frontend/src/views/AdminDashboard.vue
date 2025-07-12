<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin Dashboard</h1>
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Welcome, Admin!</h2>
        <Button
          @click="logout"
          variant="destructive"
        >
          Logout
        </Button>
      </div>

      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">User Management</h3>
        <Button @click="showUserForm = true" class="mb-4">Create New User</Button>

        <div v-if="showUserForm" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
          <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <UserForm
              :user="selectedUser"
              @userCreated="handleUserCreated"
              @userUpdated="handleUserUpdated"
              @close="showUserForm = false; selectedUser = null"
            />
          </div>
        </div>
        <div v-if="loadingUsers" class="text-center text-gray-600">Loading users...</div>
        <div v-else-if="userError" class="text-center text-red-500">{{ userError }}</div>
        <div v-else>
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="user in users" :key="user.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                <td class="px-6 py-4 whitespace-nowrap capitalize">{{ user.role }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Button variant="link" @click="editUser(user)" class="p-0 h-auto">Edit</Button>
                  <Button variant="link" @click="deleteUser(user.id)" class="p-0 h-auto text-red-600 hover:text-red-900">Delete</Button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Task Management</h3>
        <Button @click="showTaskForm = true" class="mb-4">Create New Task</Button>

        <div v-if="showTaskForm" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
          <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <TaskForm
              :task="selectedTask"
              @taskCreated="handleTaskCreated"
              @taskUpdated="handleTaskUpdated"
              @close="showTaskForm = false; selectedTask = null"
            />
          </div>
        </div>
        <div v-if="loadingTasks" class="text-center text-gray-600">Loading tasks...</div>
        <div v-else-if="taskError" class="text-center text-red-500">{{ taskError }}</div>
        <div v-else>
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="task in tasks" :key="task.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ task.title }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ task.assigned_to_user?.name || 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ new Date(task.deadline).toLocaleDateString() }}</td>
                <td class="px-6 py-4 whitespace-nowrap capitalize">{{ task.status.replace('_', ' ') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Button variant="link" @click="editTask(task)" class="p-0 h-auto">Edit</Button>
                  <Button variant="link" @click="deleteTask(task.id)" class="p-0 h-auto text-red-600 hover:text-red-900">Delete</Button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
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
import UserForm from '../components/UserForm.vue';
import TaskForm from '../components/TaskForm.vue';

const users = ref([]);
const tasks = ref([]);
const loadingUsers = ref(true);
const loadingTasks = ref(true);
const userError = ref(null);
const taskError = ref(null);
const showUserForm = ref(false);
const selectedUser = ref(null);
const showTaskForm = ref(false);
const selectedTask = ref(null);
const authStore = useAuthStore();
const router = useRouter();

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
  selectedTask.value = { ...task };
  showTaskForm.value = true;
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

<style scoped>
/* Add any component-specific styles here if needed */
</style>
