<script setup>
import { cn } from "@/lib/utils";
import { useAttrs } from "vue";

const attrs = useAttrs();
</script>

<template>
  <p :class="cn('text-sm text-muted-foreground', attrs.class ?? '')">
    <slot />
  </p>
</template>
