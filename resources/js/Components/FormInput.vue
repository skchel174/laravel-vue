<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
  modelValue: {
    type: [String, null],
    required: true,
  },
  focus: {
    type: Boolean,
    default: false,
  },
});

defineEmits(['update:modelValue']);

const inputRef = ref(null);

onMounted(() => {
  if (props.focus) {
    inputRef.value.focus();
  }
});
</script>

<template>
  <input
    ref="inputRef"
    class="w-full rounded-md text-sm shadow-sm border-gray-300 focus:border-gray-300 placeholder:text-sm focus:ring-1 text-gray-600 placeholder:text-gray-500 focus:ring-gray-500 focus:ring-offset-0"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>
