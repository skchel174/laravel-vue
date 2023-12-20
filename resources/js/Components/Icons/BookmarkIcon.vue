<script setup>
defineProps({
  isBookmarked: {
    type: Boolean,
    required: true,
  },
});

defineEmits(['toggle']);
</script>

<template>
  <span
    class="material-icons text-gray-300 !text-2xl hover:text-gray-400 active:scale-[0.95] cursor-pointer transition duration-200 select-none"
    :class="{['!text-gray-500 hover:!text-gray-600']: isBookmarked}"
    @click="$emit('toggle')"
  >
    bookmark
  </span>
</template>
