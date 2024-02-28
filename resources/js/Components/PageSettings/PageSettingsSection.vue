<script setup>
defineProps({
  title: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div>
    <div class="px-4 py-2.5 bg-sky-50">
      <p class="text-gray-500 font-medium">
        {{ title }}
      </p>
    </div>

    <div class="px-4 py-6 space-y-6">
      <slot/>
    </div>
  </div>
</template>
