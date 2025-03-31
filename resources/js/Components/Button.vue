<script setup>
const props = defineProps({
  size: {
    type: String,
    default: 'md',
    validator: (value) => {
      return ['sm', 'md'].includes(value);
    },
  },
});

const sizes = {
  sm: 'h-[26px]',
  md: 'h-[36px]',
};
</script>

<template>
  <button
    class="flex items-center justify-center rounded-md shadow px-4 py-1.5 text-sm leading-tight ring-1 transition duration-400 ease-in-out disabled:cursor-not-allowed disabled:opacity-75"
    :class="[sizes[size]]"
  >
    <slot/>
  </button>
</template>
