<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'filled',
    validator: (value) => {
      return ['filled', 'outlined'].includes(value);
    },
  },
  color: {
    type: String,
    default: 'primary',
    validator: (value) => {
      return ['primary', 'secondary', 'danger'].includes(value);
    },
  },
  size: {
    type: String,
    default: 'lg',
    validator: (value) => {
      return ['sm', 'md', 'lg'].includes(value);
    },
  },
});

const sizes = computed(() => {
  return {
    sm: 'h-[27px]',
    md: 'h-[35px]',
    lg: 'h-[43px]',
  }[props.size];
});

const colors = computed(() => {
  return {
    filled: {
      primary: 'bg-gray-950 ring-gray-950 text-white hover:opacity-85',
      secondary: 'bg-gray-300 ring-gray-300 text-gray-950 hover:opacity-85',
      danger: 'bg-red-600 ring-red-600 text-white hover:opacity-85',
    },
    outlined: {
      primary: 'ring-gray-950 text-gray-950 hover:text-white hover:bg-gray-950',
      secondary: 'ring-gray-300 text-gray-950 hover:bg-gray-200',
      danger: 'ring-red-600 text-red-600 hover:bg-red-600 hover:text-white',
    },
  }[props.variant][props.color];
});
</script>

<template>
  <button
    class="flex items-center justify-center rounded-md shadow px-4 py-1.5 text-sm leading-tight ring-1 transition duration-300 ease-in-out disabled:cursor-not-allowed disabled:opacity-75"
    :class="[sizes, colors]"
  >
    <slot />
  </button>
</template>
