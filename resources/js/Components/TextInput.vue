<script setup>
defineProps({
  modelValue: {
    type: String,
    required: true,
  },
});

defineEmits([
  'update:modelValue',
]);
</script>

<template>
  <input
    class="border-gray-300 focus:ring-0 focus:border-sky-500/70 rounded-sm transition duration-400"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>
