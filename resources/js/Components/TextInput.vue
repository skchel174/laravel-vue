<script setup>
defineProps({
  modelValue: {
    type: [String, null],
    required: true,
  },
});

defineEmits([
  'update:modelValue',
]);
</script>

<template>
  <input
    class="border-gray-300 focus:ring-0 focus:border-sky-600/50 rounded-sm transition duration-400 placeholder:text-sm placeholder:text-gray-500/75"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>
