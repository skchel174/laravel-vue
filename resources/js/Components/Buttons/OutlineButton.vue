<script setup>
import {computed} from "vue";

const props = defineProps({
  color: {
    type: String,
    default: 'primary',
    validator: (value) => {
      return ['primary', 'secondary', 'success', 'danger', 'neutral'].includes(value);
    },
  }
});

const style = computed(() => {
  return {
    primary: 'text-sky-700/75 ring-sky-700/75 hover:bg-sky-700/75 disabled:text-sky-700/75 disabled:ring-sky-700/75',
    secondary: 'text-gray-500 ring-gray-500 hover:bg-gray-500 disabled:text-gray-500 disabled:ring-gray-500',
    success: 'text-lime-700/80 ring-lime-700/80 hover:bg-lime-700/80 disabled:text-lime-700/80 disabled:ring-lime-700/80',
    danger: 'text-red-700/75 ring-red-700/75 hover:bg-red-700/75 disabled:text-red-700/75 disabled:ring-red-700/75',
    light: '!text-gray-700 ring-gray-300 hover:bg-gray-200 hover:ring-gray-200 disabled:ring-gray-300',
  }[props.color];
})
</script>

<template>
  <button
    class="py-2 px-6 inline-flex items-center justify-center ring-1 rounded-sm text-sm leading-tight disabled:bg-white hover:text-white transition duration-300 ease-in-out disabled:opacity-75 disabled:cursor-not-allowed"
    :class="style"
  >
    <slot/>
  </button>
</template>
