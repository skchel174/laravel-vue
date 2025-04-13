<script setup>
import { Link as InertiaLink } from '@inertiajs/vue3';
</script>

<template>
  <InertiaLink
    class="hover:text-gray-950 hover:underline underline-offset-4"
  >
    <slot />
  </InertiaLink>
</template>
