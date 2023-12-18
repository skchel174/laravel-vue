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

  clickable: {
    type: Boolean,
    default: false,
  },
});

const open = () => {
  if (props.clickable && props.value.default) {
    window.open(props.value.default);
  }
};
</script>

<template>
  <img
    class="flex flex-none justify-center items-center overflow-hidden rounded-full cursor-pointer"
    :class="{
      'w-9 h-9' : size === 'sm',
      'w-14 h-14': size === 'md',
      'w-20 h-20': size === 'lg',
    }"
    :src="value.thumb ?? value.mask"
    alt="avatar"
    @click="open"
  >
</template>
