<script setup>
const props = defineProps({
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md'].includes(value),
  },

  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'outline'].includes(value),
  }
});

const sizes = {
  sm: 'h-[26px]',
  md: 'h-[36px]',
};

const variants = {
  primary: 'bg-gray-950 ring-gray-950 text-white hover:opacity-85',
  secondary: 'bg-gray-300 ring-gray-300 text-gray-950 hover:opacity-85',
  outline: 'ring-gray-300 text-gray-950 hover:bg-gray-100',
}
</script>

<template>
  <button
    class="duration-400 flex items-center justify-center rounded-md px-4 py-1.5 text-sm leading-tight shadow ring-1 transition ease-in-out disabled:cursor-not-allowed disabled:opacity-75"
    :class="[sizes[size], variants[variant]]"
  >
    <slot />
  </button>
</template>
