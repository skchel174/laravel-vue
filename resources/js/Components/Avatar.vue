<script setup>
import {computed} from "vue";
import avatar from 'img/avatar.png';

const props = defineProps({
  src: {
    type: [String, null],
    required: true,
  },

  size: {
    type: String,
    default: 'sm',
  },
});

const size = computed(() => {
  switch (props.size) {
    case 'lg':
      return 'w-16 h-16';
    case 'md':
      return 'w-12 h-12';
    case 'sm':
      return 'w-10 h-10';
    case 'xs':
      return 'w-8 h-8';
  }
});
</script>

<template>
  <img
    class="rounded"
    :class="size"
    :src="src ?? avatar"
    alt="avatar"
  >
</template>
