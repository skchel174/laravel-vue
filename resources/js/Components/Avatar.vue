<script setup>
import avatar from 'img/avatar.png';

const props = defineProps({
  size: {
    type: String,
    default: 'sm',
  },

  value: {
    type: Object,
  },

  clickable: {
    type: Boolean,
    default: false,
  },

  alt: {
    type: String,
    default: 'avatar',
  },
});

const open = () => {
  if (props.clickable) {
    window.open(props.value.xl);
  }
};
</script>

<template>
  <img
    class="flex flex-none justify-center items-center overflow-hidden rounded cursor-pointer"
    :class="{
      'w-9 h-9' : size === 'sm',
      'w-14 h-14': size === 'md',
      'w-20 h-20': size === 'lg',
    }"
    :src="value ? value.sm : avatar"
    :alt="alt"
    @click="open"
  >
</template>
