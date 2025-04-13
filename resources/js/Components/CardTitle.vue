<script setup>
defineProps({
  component: {
    type: String,
    default: 'h3',
    validator(value) {
      return ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'].includes(value);
    },
  },
});
</script>

<template>
  <component :is="component" class="text-base leading-[1.5] font-semibold">
    <slot />
  </component>
</template>
