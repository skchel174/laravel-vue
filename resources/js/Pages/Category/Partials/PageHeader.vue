<script setup>
defineProps({
  category: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <header class="w-full p-4 bg-white">
    <h1 class="text-xl text-gray-700 font-semibold">
      {{ category.name }}
    </h1>
  </header>
</template>
