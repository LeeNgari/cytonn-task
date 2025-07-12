<script setup>
import { cn } from "@/lib/utils";
import { useAttrs } from "vue";

const attrs = useAttrs();
</script>

<template>
  <div :class="cn('flex flex-col space-y-1.5 p-6', attrs.class ?? '')">
    <slot />
  </div>
</template>
