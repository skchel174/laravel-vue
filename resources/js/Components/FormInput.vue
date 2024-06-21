<script setup>
const model = defineModel({
  type: String,
  required: true,
});
</script>

<template>
  <input
    class="block w-full bg-transparent border border-color-base focus:border-color-primary focus:ring-0 rounded-sm transition transition-border duration-500 text-sm font-medium text-color-base placeholder:text-sm placeholder:text-medium placeholder:text-color-light"
    v-model="model"
  />
</template>
