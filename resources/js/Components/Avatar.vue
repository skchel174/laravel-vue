<script setup>
const props = defineProps({
  size: {
    type: String,
    default: 'sm',
  },

  value: {
    type: Object,
  },

  alt: {
    type: String,
    default: 'avatar',
  },
});

const open = () => {
  window.open(props.value.xl);
};
</script>

<template>
  <div
    class="flex justify-center items-center overflow-hidden rounded-sm"
    :class="{
      'w-8 h-8 text-2xl' : size === 'xs',
      'w-9 h-9 text-3xl' : size === 'sm',
      'w-14 h-14 text-4xl': size === 'md',
      'w-20 h-20 text-5xl': size === 'lg',
      'border opacity-75 border-sky-600/70 text-sky-600': !value,
    }"
  >
    <img
      class="cursor-pointer"
      v-if="value"
      :src="value.sm"
      :alt="alt"
      @click="open"
    >

    <span v-else class="material-icons !text-[1em]">
      person
    </span>
  </div>
</template>
