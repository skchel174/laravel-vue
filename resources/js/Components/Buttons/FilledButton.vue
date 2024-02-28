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
    primary: 'bg-sky-675 ring-sky-675 hover:bg-sky-775 hover:ring-sky-775 disabled:bg-sky-675 disabled:ring-sky-675',
    secondary: 'bg-gray-500 ring-gray-500 hover:bg-gray-600 hover:ring-gray-600 disabled:bg-gray-500 disabled:ring-gray-500',
    success: 'bg-lime-680 ring-lime-680 hover:bg-lime-775 hover:ring-lime-775 disabled:bg-lime-680 disabled:ring-lime-680',
    danger: 'bg-red-675 ring-red-675 hover:bg-red-775 hover:ring-red-775 disabled:bg-red-675 disabled:ring-red-675',
    light: 'bg-gray-200 ring-gray-200 hover:bg-gray-275 hover:ring-gray-275 !text-gray-700 disabled:bg-gray-200 disabled:ring-gray-200',
  }[props.color];
})
</script>

<template>
  <button
    class="py-2 px-6 inline-flex items-center justify-center ring-1 rounded-sm text-sm text-white leading-tight transition duration-300 ease-in-out disabled:opacity-75 disabled:cursor-not-allowed"
    :class="style"
  >
    <slot/>
  </button>
</template>
