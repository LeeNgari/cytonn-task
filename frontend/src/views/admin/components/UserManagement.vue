<template>
  <div>
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
import UserForm from '@/components/UserForm.vue'
import CardSkeleton from '@/components/CardSkeleton.vue'

import { Button } from '@/components/ui/button'
import { CardTitle } from '@/components/ui/card'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Badge } from '@/components/ui/badge'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog'

const users = ref([])
const loadingUsers = ref(true)
const userError = ref(null)
const showUserForm = ref(false)
const selectedUser = ref(null)

// Helper functions
const capitalize = (str) => str.charAt(0).toUpperCase() + str.slice(1)

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

onMounted(() => {
  fetchUsers();
});
</script>
