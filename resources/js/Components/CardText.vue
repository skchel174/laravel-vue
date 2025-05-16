<script setup>
defineProps({
  component: {
    type: String,
    default: 'p',
    validator(value) {
      return ['p', 'span'].includes(value);
    },
  },
});
</script>

<template>
  <component :is="component" class="text-sm font-light leading-[1.35]">
    <slot />
  </component>
</template>
