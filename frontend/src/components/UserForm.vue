<template>
  <div class="p-4">
    <h2 class="text-xl font-semibold mb-4">{{ isEdit ? 'Edit User' : 'Create New User' }}</h2>
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input
          type="text"
          id="name"
          v-model="userForm.name"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />
      </div>
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input
          type="email"
          id="email"
          v-model="userForm.email"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />
      </div>
      <div v-if="!isEdit">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input
          type="password"
          id="password"
          v-model="userForm.password"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />
      </div>
      <div v-if="!isEdit">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input
          type="password"
          id="password_confirmation"
          v-model="userForm.password_confirmation"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />
      </div>
      <div>
        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
        <select
          id="role"
          v-model="userForm.role"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>
      <div class="flex justify-end space-x-2">
        <Button type="button" variant="outline" @click="$emit('close')">Cancel</Button>
        <Button type="submit" :disabled="isLoading">
          <span v-if="isLoading">Saving...</span>
          <span v-else>{{ isEdit ? 'Update User' : 'Create User' }}</span>
        </Button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { API_BASE_URL } from '../config';
import { Button } from '../components/ui/button';

const props = defineProps({
  user: { type: Object, default: null },
});

const emit = defineEmits(['userCreated', 'userUpdated', 'close']);

const isEdit = ref(false);
const isLoading = ref(false);
const userForm = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'user',
});
const error = ref(null);

watch(() => props.user, (newUser) => {
  if (newUser) {
    isEdit.value = true;
    userForm.value = { ...newUser, password: '', password_confirmation: '' };
  } else {
    isEdit.value = false;
    userForm.value = {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      role: 'user',
    };
  }
}, { immediate: true });

const handleSubmit = async () => {
  error.value = null;
  isLoading.value = true;
  try {
    if (isEdit.value) {
      const payload = { name: userForm.value.name, email: userForm.value.email, role: userForm.value.role };
      if (userForm.value.password) {
        payload.password = userForm.value.password;
        payload.password_confirmation = userForm.value.password_confirmation;
      }
      const response = await axios.put(`${API_BASE_URL}/users/${userForm.value.id}`, payload);
      emit('userUpdated', response.data);
    } else {
      const response = await axios.post(`${API_BASE_URL}/users`, userForm.value);
      emit('userCreated', response.data);
    }
    emit('close');
  } catch (err) {
    error.value = err.response?.data?.message || 'An error occurred.';
    if (err.response?.data?.errors) {
      for (const key in err.response.data.errors) {
        error.value += ` ${key}: ${err.response.data.errors[key].join(', ')}`;
      }
    }
  } finally {
    isLoading.value = false;
  }
};
</script>
