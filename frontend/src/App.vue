<template>
  <router-view />
    <Toaster />
</template>

<script setup>
// No script needed for a simple router-view wrapper
import { Toaster } from '@/components/ui/sonner'
</script>

<style>
/* You can add global styles here if needed */
</style>