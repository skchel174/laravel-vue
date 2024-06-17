<script setup>
const model = defineModel({
  type: String,
  required: true,
});
</script>

<template>
  <input
    class="block w-full bg-transparent border border-gray-300 focus:border-sky-500 focus:ring-0 rounded-sm transition transition-border duration-500 text-sm font-medium text-gray-700 placeholder:text-sm placeholder:text-medium placeholder:text-gray-500"
    v-model="model"
  />
</template>
