<script setup>
defineProps({
  count: {
    type: Number,
    required: true,
  },
});
</script>

<template>
  <div class="flex items-center justify-center space-x-1.5">
    <span class="material-icons text-gray-300 !text-2xl">
      visibility
    </span>
    <span class="text-xs font-bold text-gray-400 ml-2">
      {{ $formatCount($props.count) }}
    </span>
  </div>
</template>
