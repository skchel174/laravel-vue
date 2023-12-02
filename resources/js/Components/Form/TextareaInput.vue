<script setup>
import {ref} from "vue";

defineProps({
  modelValue: {
    type: String,
    required: true,
  },
});

const emit = defineEmits([
  'update:modelValue',
]);

const el = ref(null);

const handleInput = ({target}) => {
  el.value.style.height = 'auto';
  el.value.style.height = el.value.scrollHeight + 'px';

  emit('update:modelValue', target.value);
};

const handleKeydown = (event) => {
  if (event.key === 'Enter') {
    event.preventDefault();
    el.value.blur();
  }
};
</script>

<template>
  <textarea
    ref="el"
    :value="modelValue"
    @input="handleInput"
    @keydown="handleKeydown"
    class="w-full resize-none overflow-hidden outline-none border-gray-300 focus:ring-0 focus:border-sky-500/70 rounded-sm transition duration-700 rounded-sm placeholder:text-gray-300"
    rows="1"
  />
</template>
