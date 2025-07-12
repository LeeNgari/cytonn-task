<template>
  <div class="p-4">
    <h2 class="text-xl font-semibold mb-4">{{ isEdit ? 'Edit Task' : 'Create New Task' }}</h2>
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input
          type="text"
          id="title"
          v-model="taskForm.title"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />
      </div>
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea
          id="description"
          v-model="taskForm.description"
          rows="3"
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        ></textarea>
      </div>
      <div>
        <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigned To</label>
        <select
          id="assigned_to"
          v-model="taskForm.assigned_to"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
          <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
        </select>
      </div>
      <div>
        <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
        <input
          type="datetime-local"
          id="deadline"
          v-model="taskForm.deadline"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />
      </div>
      <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <select
          id="status"
          v-model="taskForm.status"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
          <option value="pending">Pending</option>
          <option value="in_progress">In Progress</option>
          <option value="completed">Completed</option>
        </select>
      </div>
      <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
      <div class="flex justify-end space-x-2">
        <Button type="button" variant="outline" @click="$emit('close')">Cancel</Button>
        <Button type="submit">{{ isEdit ? 'Update Task' : 'Create Task' }}</Button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';
import { API_BASE_URL } from '../config';
import { Button } from '../components/ui/button';

const props = defineProps({
  task: { type: Object, default: null },
});

const emit = defineEmits(['taskCreated', 'taskUpdated', 'close']);

const isEdit = ref(false);
const taskForm = ref({
  title: '',
  description: '',
  assigned_to: null,
  deadline: '',
  status: 'pending',
});
const users = ref([]);
const error = ref(null);

const fetchUsers = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/users`);
    users.value = response.data;
  } catch (err) {
    console.error('Failed to fetch users:', err);
    error.value = 'Failed to load users for assignment.';
  }
};

watch(() => props.task, (newTask) => {
  if (newTask) {
    isEdit.value = true;
    taskForm.value = { ...newTask };
    // Format deadline for datetime-local input
    if (taskForm.value.deadline) {
      taskForm.value.deadline = new Date(newTask.deadline).toISOString().slice(0, 16);
    }
  } else {
    isEdit.value = false;
    taskForm.value = {
      title: '',
      description: '',
      assigned_to: null,
      deadline: '',
      status: 'pending',
    };
  }
}, { immediate: true });

const handleSubmit = async () => {
  error.value = null;
  try {
    if (isEdit.value) {
      const response = await axios.put(`${API_BASE_URL}/tasks/${taskForm.value.id}`, taskForm.value);
      emit('taskUpdated', response.data);
    } else {
      const response = await axios.post(`${API_BASE_URL}/tasks`, taskForm.value);
      emit('taskCreated', response.data);
    }
    emit('close');
  } catch (err) {
    error.value = err.response?.data?.message || 'An error occurred.';
    if (err.response?.data?.errors) {
      for (const key in err.response.data.errors) {
        error.value += ` ${key}: ${err.response.data.errors[key].join(', ')}`;
      }
    }
  }
};

onMounted(() => {
  fetchUsers();
});
</script>
