<script setup>
defineProps({
  value: String,
});
</script>

<template>
  <p v-if="value" class="pl-[2px] text-sm text-red-600">
    {{ value }}
  </p>
</template>
