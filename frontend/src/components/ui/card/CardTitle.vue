<script setup>
import { cn } from "@/lib/utils";
import { useAttrs } from "vue";

const attrs = useAttrs();
</script>

<template>
  <h3
    :class="
      cn(
        'text-2xl font-semibold leading-none tracking-tight',
        attrs.class ?? ''
      )
    "
  >
    <slot />
  </h3>
</template>
