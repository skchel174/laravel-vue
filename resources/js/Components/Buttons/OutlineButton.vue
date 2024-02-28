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
    primary: 'text-sky-675 ring-sky-675 hover:bg-sky-675 disabled:text-sky-675 disabled:ring-sky-675',
    secondary: 'text-gray-500 ring-gray-500 hover:bg-gray-500 disabled:text-gray-500 disabled:ring-gray-500',
    success: 'text-lime-680 ring-lime-680 hover:bg-lime-680 disabled:text-lime-680 disabled:ring-lime-680',
    danger: 'text-red-675 ring-red-675 hover:bg-red-675 disabled:text-red-675 disabled:ring-red-675',
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
