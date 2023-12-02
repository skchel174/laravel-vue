<script setup>
const props = defineProps({
  size: {
    type: String,
    default: 'sm',
  },

  image: {
    type: String,
  },

  fullImage: {
    type: String,
  },

  alt: {
    type: String,
    default: 'avatar',
  },
});

const open = () => {
  if (props.fullImage) {
    window.open(props.fullImage);
  }
};
</script>

<template>
  <div
    class="flex justify-center items-center overflow-hidden rounded-sm"
    :class="{
      'w-10 h-10 text-3xl' : size === 'sm',
      'w-14 h-14 text-4xl': size === 'md',
      'w-20 h-20 text-5xl': size === 'lg',
      'border opacity-75 border-sky-600/70': !image,
    }"
  >
    <img
      class="cursor-pointer"
      v-if="image"
      :src="image"
      :alt="alt"
      @click="open"
    >

    <span v-else class="material-icons !text-[1em] !text-sky-600">
      person
    </span>
  </div>
</template>
