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
  <component :is="component" class="text-sm text-gray-400 font-light leading-[1.5]">
    <slot />
  </component>
</template>
