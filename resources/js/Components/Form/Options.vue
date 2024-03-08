<script setup>
defineProps(['modelValue']);
defineEmits(['update:modelValue'])
</script>

<template>
  <select
    class="w-full px-2 border border-gray-300 focus:ring-0 focus:border-sky-600/50 transition duration-400 rounded-sm text-sm text-gray-600"
    :value="modelValue"
    @change="$emit('update:modelValue', $event.target.value)"
  >
    <slot/>
  </select>
</template>
