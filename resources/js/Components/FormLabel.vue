<script setup>
defineProps({
  value: String,
  error: { type: Boolean, default: false },
});
</script>

<template>
  <label
    class="pl-[2px] text-sm font-medium text-gray-800"
    :class="{ 'text-red-600': error }"
  >
    <span v-if="value">{{ value }}</span>
    <span v-else><slot /></span>
  </label>
</template>
