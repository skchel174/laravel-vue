<script setup>
import {computed} from "vue";

const props = defineProps({
  color: {
    type: String,
    default: 'primary',
    validator: (value) => {
      return ['primary', 'secondary', 'success', 'danger', 'light'].includes(value);
    },
  }
});

const style = computed(() => {
  return {
    primary: 'bg-sky-700/75 ring-sky-700/75 hover:bg-sky-600 hover:ring-sky-600 disabled:bg-sky-700/75 disabled:ring-sky-700/75',
    secondary: 'bg-gray-500 ring-gray-500 hover:bg-gray-600 hover:ring-gray-600 disabled:bg-gray-500 disabled:ring-gray-500',
    success: 'bg-lime-700/80 ring-lime-700/80 hover:bg-lime-800/75 hover:ring-lime-800/75 disabled:bg-lime-700/80 disabled:ring-lime-700/80',
    danger: 'bg-red-700/75 ring-red-700/75 hover:bg-red-800/75 hover:ring-red-800/75 disabled:bg-red-700/75 disabled:ring-red-700/75',
    light: 'bg-gray-200 ring-gray-200 hover:bg-gray-300/75 hover:ring-gray-300/75 !text-gray-700 disabled:bg-gray-200 disabled:ring-gray-200',
  }[props.color];
})
</script>

<template>
  <button
    class="py-2 px-6 inline-flex items-center justify-center ring-1 rounded-sm text-sm text-white leading-tight transition duration-300 ease-in-out disabled:bg-sky-700/75 disabled:ring-sky-700/75 disabled:opacity-75 disabled:cursor-not-allowed"
    :class="style"
  >
    <slot/>
  </button>
</template>
