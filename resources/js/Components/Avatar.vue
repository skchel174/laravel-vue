<script setup>
import {computed} from "vue";

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

const baseStyles = computed(() => ({
  'w-8 h-8': props.size === 'xs',
  'w-10 h-10' : props.size === 'sm',
  'w-12 h-12': props.size === 'md',
  'w-16 h-16': props.size === 'lg',
  'border-none': props.src,
}));

const iconStyles = computed(() => ({
  '!text-2xl': props.size === 'xs',
  '!text-3xl' : props.size === 'sm',
  '!text-4xl': props.size === 'md',
  '!text-5xl': props.size === 'lg',
}));
</script>

<template>
  <div
    class="flex justify-center items-center overflow-hidden rounded text-gray-300 border border-gray-300"
    :class="baseStyles"
  >
    <img
      v-if="src"
      :src="src"
      alt="avatar"
    >

    <span
      class="material-icons text-inherit"
      :class="iconStyles"
      v-else
    >
      person
    </span>
  </div>
</template>
