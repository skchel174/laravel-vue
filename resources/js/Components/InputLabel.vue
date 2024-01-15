<script setup>
defineProps({
  value: {
    type: String,
  },
});
</script>

<template>
  <label class="font-medium text-sm text-gray-700">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot/></span>
  </label>
</template>
