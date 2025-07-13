<template>
  <div 
    class="p-4 border rounded-lg animate-pulse"
    :class="{
      'space-y-3': type === 'user',
      'space-y-4': type === 'task'
    }"
  >
    <!-- User Skeleton -->
    <template v-if="type === 'user'">
      <div class="flex items-center space-x-3">
        <div class="h-9 w-9 rounded-full bg-gray-200"></div>
        <div class="space-y-2 flex-1">
          <div class="h-3.5 bg-gray-200 rounded w-24"></div>
          <div class="h-3 bg-gray-200 rounded w-32"></div>
        </div>
        <div class="h-8 w-16 bg-gray-200 rounded-md"></div>
      </div>
    </template>

    <!-- Task Skeleton -->
    <template v-else-if="type === 'task'">
      <div class="h-4 bg-gray-200 rounded w-3/4"></div>
      <div class="flex items-center justify-between pt-1">
        <div class="flex items-center space-x-2">
          <div class="h-6 w-6 rounded-full bg-gray-200"></div>
          <div class="h-3 bg-gray-200 rounded w-16"></div>
        </div>
        <div class="flex space-x-2">
          <div class="h-6 w-20 bg-gray-200 rounded-md"></div>
          <div class="h-6 w-20 bg-gray-200 rounded-md"></div>
        </div>
      </div>
      <div class="flex justify-end space-x-2 pt-1">
        <div class="h-8 w-8 bg-gray-200 rounded-md"></div>
        <div class="h-8 w-8 bg-gray-200 rounded-md"></div>
      </div>
    </template>

    <!-- Default Skeleton -->
    <template v-else>
      <div class="h-4 bg-gray-200 rounded w-3/4"></div>
      <div class="h-3 bg-gray-200 rounded mt-2"></div>
      <div class="h-3 bg-gray-200 rounded w-5/6 mt-2"></div>
    </template>
  </div>
</template>

<script setup>
defineProps({
  type: {
    type: String,
    default: '', // 'user' or 'task'
    validator: (value) => ['', 'user', 'task'].includes(value)
  }
})
</script>

<style scoped>
.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>