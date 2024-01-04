<script setup>
const props = defineProps({
  value: {
    type: Object,
    required: true,
  },

  size: {
    type: String,
    default: 'sm',
  },
});
</script>

<template>
  <img
    class="flex justify-center items-center overflow-hidden rounded-full cursor-pointer"
    :class="{
      'w-8 h-8': size === 'xs',
      'w-10 h-10' : size === 'sm',
      'w-14 h-14': size === 'md',
      'w-20 h-20': size === 'lg',
    }"
    :src="value.thumb ?? value.mask"
    alt="avatar"
  >
</template>
