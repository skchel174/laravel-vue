<script setup>
defineProps({
  component: {
    type: String,
    default: 'p',
    validator: (value) => ['p', 'span'].includes(value),
  },
});
</script>

<template>
  <component
    :is="component"
    class="text-sm font-light leading-[1.5] text-gray-500"
  >
    <slot />
  </component>
</template>
