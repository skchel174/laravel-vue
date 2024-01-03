<script setup>
defineProps({
  text: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div class="space-y-2">
    <h5 class="text-sm text-gray-700 font-bold">
      About
    </h5>

    <p class="text-sm text-gray-500 font-medium">
      {{ text }}
    </p>
  </div>
</template>
