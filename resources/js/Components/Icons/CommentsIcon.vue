<script setup>
defineProps({
  count: {
    type: Number,
    required: true,
  },
});
</script>

<template>
  <div class="flex items-center justify-center">
    <span class="material-icons text-gray-300 !text-xl select-none">
      chat_bubble
    </span>
    <span class="text-xs font-medium text-gray-400 ml-2">
      {{ $formatCount($props.count) }}
    </span>
  </div>
</template>
