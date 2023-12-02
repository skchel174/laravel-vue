<script setup>
const props = defineProps({
  input: {
    type: String,
    required: true,
  },

  maxLength: {
    type: Number,
    required: true,
  },

  visible: {
    type: Boolean,
    default: true,
  },
});
</script>

<template>
  <Transition
    enter-from-class="opacity-0"
    enter-active-class="transition transition-opacity duration-200 ease-in"
    enter-to-class="opacity-1"
    leave-from-class="opacity-1"
    leave-active-class="transition transition-opacity duration-200 ease-out"
    leave-to-class="opacity-0"
  >
    <span
      v-if="visible"
      class="text-xs text-gray-500"
    >
      {{ input.length }}/{{ maxLength }}
    </span>
  </Transition>
</template>
