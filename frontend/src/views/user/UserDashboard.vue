<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4">
    <div class="max-w-7xl mx-auto">
      <UserHeader />
      <UserTaskOverview  class="w-full" />
    </div>
  </div>
</template>

<script setup>
import UserHeader from './components/UserHeader.vue'
import UserTaskOverview from './components/UserTaskOverview.vue'
</script>

<style scoped>
/* Custom transitions */
.hover\:shadow-md {
  transition: box-shadow 0.2s ease;
}
</style>
