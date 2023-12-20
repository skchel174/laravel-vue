<script setup>
defineProps({
  isLiked: {
    type: Boolean,
    required: true,
  },

  count: {
    type: Number,
    required: true,
  },
});

defineEmits(['toggle']);
</script>

<template>
  <div class="flex items-center justify-center">
    <span
      class="material-icons !text-xl text-gray-300 hover:text-gray-400 active:scale-[0.95] cursor-pointer transition duration-200 select-none"
      :class="{['!text-gray-500 hover:!text-gray-600']: isLiked}"
      @click="$emit('toggle')"
    >
      favorite
    </span>
    <span class="text-xs font-medium text-gray-400 ml-2">
      {{ $formatCount(count) }}
    </span>
  </div>
</template>
