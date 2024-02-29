<script setup>
import {onMounted, ref, watch} from "vue";

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
    class="border-gray-300 focus:ring-0 focus:border-sky-600/50 rounded-sm transition duration-400 placeholder:text-sm placeholder:text-gray-500/75"
    ref="inputRef"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>
