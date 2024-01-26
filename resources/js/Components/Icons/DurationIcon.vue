<script setup>
defineProps({
  value: {
    type: Number,
    required: true,
  },
});
</script>

<template>
  <div class="flex items-center space-x-1">
    <span class="material-icons !text-xl text-gray-300">
      watch_later
    </span>
    <span class="text-xs font-bold capitalize text-gray-400">
      {{ value }} {{ $trans('min') }}
    </span>
  </div>
</template>
